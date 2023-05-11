<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\Source\Type\Spout;

use Amasty\ImportCore\Api\Source\SourceGeneratorInterface;
use Amasty\ImportCore\Import\Config\ProfileConfig;
use Amasty\ImportCore\Import\Config\Source\Type\TableConfigAdapter\Builder;
use Amasty\ImportCore\Import\Utils\TmpFileManagement;
use Amasty\ImportCore\Import\Utils\Type\Table\Row\Converter;
use Amasty\ImportCore\Import\Utils\Type\Table\Row\Header\DataHandler;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Math\Random;
use Amasty\ExportPro\Export\Template\Type\Ods\ConfigInterface as OdsConfigInterface;
use Amasty\ExportPro\Export\Template\Type\Xlsx\ConfigInterface as XlsxConfigInterface;

abstract class Generator implements SourceGeneratorInterface
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Random
     */
    protected $random;

    /**
     * @var DataHandler
     */
    protected $headerDataHandler;

    /**
     * @var Converter
     */
    protected $rowConverter;

    public function __construct(
        Filesystem $filesystem,
        Random $random,
        DataHandler $headerDataHandler,
        Converter $rowConverter,
        Builder $tableConfigAdapterBuilder
    ) {
        $this->filesystem = $filesystem;
        $this->random = $random;
        $this->headerDataHandler = $headerDataHandler;
        $this->rowConverter = $rowConverter;
        $this->tableConfigAdapterBuilder = $tableConfigAdapterBuilder;
    }

    public function generate(ProfileConfig $profileConfig, array $data): string
    {
        $randomName = $this->random->getRandomString(TmpFileManagement::TEMP_FILE_NAME_LENGTH);
        $tmpDir = $this->filesystem->getDirectoryWrite(DirectoryList::SYS_TMP);
        $tmpDir->touch($randomName);

        $writer = WriterFactory::createFromType($this->getExtension());
        $writer->openToFile($tmpDir->getAbsolutePath($randomName));

        $config = $this->getConfig($profileConfig);
        $headerStructure = $this->getHeaderStructure($profileConfig, $data);
        $headerForOutput = $this->headerDataHandler->getHeaderForOutput(
            $headerStructure,
            $profileConfig->getEntitiesConfig()->getMap() ?? '',
            $config->getPrefix()
        );
        $writer->addRows([WriterEntityFactory::createRowFromArray($headerForOutput)]);

        $preparedRows = [];
        $tableConfigAdapter = $this->tableConfigAdapterBuilder->build($profileConfig);
        $convertedRows = $this->rowConverter->convert($tableConfigAdapter, $data, $headerStructure);
        foreach ($convertedRows as $convertedRow) {
            $preparedRows[] = WriterEntityFactory::createRowFromArray($convertedRow);
        }
        $writer->addRows($preparedRows);
        $writer->close();

        $content = $tmpDir->getDriver()->fileGetContents($tmpDir->getAbsolutePath($randomName));
        $tmpDir->delete($randomName);

        return $content;
    }

    protected function getHeaderStructure(ProfileConfig $profileConfig, array $data)
    {
        $headerMap = $this->headerDataHandler->getHeaderMap($profileConfig->getEntitiesConfig(), $data[0]);

        return $this->headerDataHandler->getHeaderStructureByMap($headerMap);
    }

    abstract public function getExtension(): string;

    /**
     * @param ProfileConfig $profileConfig
     * @return OdsConfigInterface|XlsxConfigInterface
     */
    abstract protected function getConfig(ProfileConfig $profileConfig);
}

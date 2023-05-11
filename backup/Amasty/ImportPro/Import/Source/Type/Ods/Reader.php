<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\Source\Type\Ods;

use Amasty\ImportCore\Api\ImportProcessInterface;

class Reader extends \Amasty\ImportPro\Import\Source\Type\Spout\Reader
{
    public const TYPE_ID = 'ods';

    public function estimateRecordsCount(): int
    {
        $rows = 0;
        $sheetIterator = $this->fileReader->getSheetIterator();
        $rowIterator = $sheetIterator->current()->getRowIterator();

        foreach ($rowIterator as $row) {
            if ($row) {
                $rows++;
            }
        }
        $sheetIterator->rewind();
        $this->readTypeMatchedRow(); //skip reading header row

        return $rows;
    }

    protected function getSourceConfig(ImportProcessInterface $importProcess)
    {
        return $importProcess->getProfileConfig()->getExtensionAttributes()->getOdsSource();
    }

    protected function readTypeMatchedRow()
    {
        do {
            $sheetIterator = $this->fileReader->getSheetIterator();
            //todo: Remove after updating library "box/spout"
            $currentErrorLevel = error_reporting();
            error_reporting($currentErrorLevel & ~E_DEPRECATED);
            $rowIterator = $sheetIterator->current()->getRowIterator();
            error_reporting($currentErrorLevel);
            $rowIterator->next();
            $rowData = $rowIterator->current()->toArray();

            if (empty($rowData)) {
                return false;
            }
            $rowData = $this->prepareRowData($rowData);
        } while ($this->isRowEmpty($rowData));

        return $rowData;
    }
}

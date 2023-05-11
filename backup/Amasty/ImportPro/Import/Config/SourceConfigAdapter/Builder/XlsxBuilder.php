<?php
declare(strict_types=1);

namespace Amasty\ImportCore\Import\Config\Source\Type\TableConfigAdapter\Builder;

use Amasty\ImportCore\Import\Config\ProfileConfig;
use Amasty\ImportCore\Import\Config\Source\Type\TableConfigAdapter;

class XlsxBuilder implements BuilderInterface
{
    public function build(ProfileConfig $profileConfig, array $data): array
    {
        $xlsxSourceConfig = $profileConfig->getExtensionAttributes()->getXlsxSource();
        if ($xlsxSourceConfig) {
            $data = [
                TableConfigAdapter::CHILD_ROW_SEPARATOR => $xlsxSourceConfig->getChildRowSeparator(),
                TableConfigAdapter::IS_COMBINE_CHILD_ROWS => $xlsxSourceConfig->isCombineChildRows(),
                TableConfigAdapter::IS_DUPLICATE_PARENT_DATA => false
            ];
        }

        return $data;
    }
}

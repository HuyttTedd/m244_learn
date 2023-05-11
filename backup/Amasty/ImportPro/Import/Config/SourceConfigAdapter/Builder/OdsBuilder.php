<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\Config\Source\Type\TableConfigAdapter\Builder;

use Amasty\ImportCore\Import\Config\ProfileConfig;
use Amasty\ImportCore\Import\Config\Source\Type\TableConfigAdapter\Builder\BuilderInterface;
use Amasty\ImportCore\Import\Config\Source\Type\TableConfigAdapter;

class OdsBuilder implements BuilderInterface
{
    public function build(ProfileConfig $profileConfig, array $data): array
    {
        $odsSourceConfig = $profileConfig->getExtensionAttributes()->getOdsSource();
        if ($odsSourceConfig) {
            $data = [
                TableConfigAdapter::CHILD_ROW_SEPARATOR => $odsSourceConfig->getChildRowSeparator(),
                TableConfigAdapter::IS_COMBINE_CHILD_ROWS => $odsSourceConfig->isCombineChildRows(),
                TableConfigAdapter::IS_DUPLICATE_PARENT_DATA => false
            ];
        }

        return $data;
    }
}

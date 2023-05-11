<?php

declare(strict_types=1);

namespace Amasty\ImportCore\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

/**
 * @codeCoverageIgnore
 */
class Uninstall implements UninstallInterface
{
    public const TABLE_NAMES = [
        \Amasty\ImportCore\Model\Batch\ResourceModel\Batch::TABLE_NAME,
        \Amasty\ImportCore\Model\Process\ResourceModel\Process::TABLE_NAME,
        \Amasty\ImportCore\Model\FileUploadMap\ResourceModel\FileUploadMap::TABLE_NAME,
    ];

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this
            ->uninstallTables($setup)
            ->uninstallConfigData($setup);
    }

    private function uninstallTables(SchemaSetupInterface $setup): self
    {
        $setup->startSetup();
        foreach (self::TABLE_NAMES as $tableName) {
            $setup->getConnection()->dropTable($setup->getTable($tableName));
        }
        $setup->endSetup();

        return $this;
    }

    private function uninstallConfigData(SchemaSetupInterface $setup): self
    {
        $configTable = $setup->getTable('core_config_data');
        $setup->getConnection()->delete($configTable, "`path` LIKE 'amasty_import/%'");

        return $this;
    }
}

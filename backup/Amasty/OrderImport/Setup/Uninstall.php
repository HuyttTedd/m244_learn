<?php

declare(strict_types=1);

namespace Amasty\OrderImport\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    public const TABLE_NAMES = [
        \Amasty\OrderImport\Model\Profile\ResourceModel\Profile::TABLE_NAME
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
        $setup->getConnection()->delete($configTable, "`path` LIKE 'amorderimport/%'");

        return $this;
    }
}

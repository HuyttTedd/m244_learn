<?php

declare(strict_types=1);

namespace Amasty\ImportPro\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

class Uninstall implements UninstallInterface
{
    public const TABLE_NAMES = [
        \Amasty\ImportPro\Model\Job\ResourceModel\Job::TABLE_NAME,
        \Amasty\ImportPro\Model\History\ResourceModel\History::TABLE_NAME
    ];

    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        foreach (self::TABLE_NAMES as $tableName) {
            $setup->getConnection()->dropTable($setup->getTable($tableName));
        }

        $setup->endSetup();
    }
}

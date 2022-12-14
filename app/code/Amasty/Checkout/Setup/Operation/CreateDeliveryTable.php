<?php

namespace Amasty\Checkout\Setup\Operation;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Amasty\Checkout\Model\ResourceModel\Delivery;

/**
 * Class CreateDeliveryTable
 */
class CreateDeliveryTable
{
    /**
     * @param SchemaSetupInterface $setup
     */
    public function execute(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->createTable(
            $this->createTable($setup)
        );
    }

    /**
     * @param SchemaSetupInterface $setup
     *
     * @return Table
     */
    private function createTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getTable(Delivery::MAIN_TABLE);

        return $table = $setup->getConnection()
            ->newTable($table)
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                'order_id',
                Table::TYPE_INTEGER,
                10,
                ['unsigned' => true, 'nullable' => true],
                'Order Id'
            )
            ->addColumn(
                'quote_id',
                Table::TYPE_INTEGER,
                10,
                ['unsigned' => true, 'nullable' => true],
                'Quote Id'
            )
            ->addColumn(
                'date',
                Table::TYPE_DATE,
                null,
                ['nullable' => true],
                'Delivery Date'
            )
            ->addColumn(
                'time',
                Table::TYPE_SMALLINT,
                2,
                ['nullable' => true],
                'Delivery Time'
            )
            ->addForeignKey(
                $setup->getFkName(
                    Delivery::MAIN_TABLE,
                    'order_id',
                    'sales_order',
                    'entity_id'
                ),
                'order_id',
                $setup->getTable('sales_order'),
                'entity_id',
                Table::ACTION_CASCADE
            )
            ->addForeignKey(
                $setup->getFkName(
                    Delivery::MAIN_TABLE,
                    'quote_id',
                    'quote',
                    'entity_id'
                ),
                'quote_id',
                $setup->getTable('quote'),
                'entity_id',
                Table::ACTION_SET_NULL
            )
            ->setComment('Amasty Checkout Delivery Table');
    }
}

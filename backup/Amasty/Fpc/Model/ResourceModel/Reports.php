<?php

namespace Amasty\Fpc\Model\ResourceModel;

use Amasty\Fpc\Setup\Operation\CreateReportsTable;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Reports extends AbstractDb
{
    public function _construct()
    {
        $this->_init(CreateReportsTable::TABLE_NAME, 'date');
    }
}

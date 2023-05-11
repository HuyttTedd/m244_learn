<?php

namespace Amasty\Fpc\Model\ResourceModel;

use Amasty\Fpc\Setup\Operation\CreateFlushPagesTable;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FlushPages extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(CreateFlushPagesTable::TABLE_NAME, 'id');
    }
}

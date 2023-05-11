<?php

namespace Amasty\Fpc\Model\ResourceModel\Log;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init(
            'Amasty\Fpc\Model\Log', 'Amasty\Fpc\Model\ResourceModel\Log'
        );
    }
}

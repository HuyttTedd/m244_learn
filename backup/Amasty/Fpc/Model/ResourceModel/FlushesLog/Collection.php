<?php

namespace Amasty\Fpc\Model\ResourceModel\FlushesLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Amasty\Fpc\Model\FlushesLog;
use Amasty\Fpc\Model\ResourceModel\FlushesLog as FlushesLogResource;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(FlushesLog::class, FlushesLogResource::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }
}

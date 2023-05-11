<?php

namespace Amasty\Fpc\Model\ResourceModel\DebugContext;

use Amasty\Fpc\Model\Debug\DebugContext;
use Amasty\Fpc\Model\ResourceModel\DebugContext as DebugContextResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _construct()
    {
        $this->_init(DebugContext::class, DebugContextResource::class);
    }
}

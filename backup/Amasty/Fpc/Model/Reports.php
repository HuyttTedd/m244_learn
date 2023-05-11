<?php

namespace Amasty\Fpc\Model;

use Magento\Framework\Model\AbstractModel;

class Reports extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Amasty\Fpc\Model\ResourceModel\Reports::class);
    }
}

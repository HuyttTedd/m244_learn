<?php

namespace Amasty\Fpc\Model;

use Magento\Framework\Model\AbstractModel;

class FlushPages extends AbstractModel
{
    public function _construct()
    {
        $this->_init(ResourceModel\FlushPages::class);
    }
}

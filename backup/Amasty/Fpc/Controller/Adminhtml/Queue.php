<?php

namespace Amasty\Fpc\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class Queue extends Action
{
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Amasty_Fpc::queue');
    }
}

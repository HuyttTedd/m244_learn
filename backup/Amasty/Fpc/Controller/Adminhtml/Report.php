<?php

namespace Amasty\Fpc\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class Report extends Action
{
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Amasty_Fpc::reports');
    }
}

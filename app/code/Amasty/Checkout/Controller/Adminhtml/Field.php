<?php

namespace Amasty\Checkout\Controller\Adminhtml;

use Magento\Backend\App\Action;

/**
 * Class Field
 */
abstract class Field extends Action
{
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Amasty_Checkout::checkout_settings_fields');
    }
}

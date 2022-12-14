<?php

namespace Amasty\Checkout\Block\Adminhtml\Field\Edit;

/**
 * Class Tabs
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('amasty_checkout_fields_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('CHECKOUT FIELDS CONFIGURATION'));
    }
}

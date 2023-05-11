<?php

namespace Amasty\Blog\Block\Adminhtml;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class
 */
class SaveAndContinueButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'on_click' => '',
            'sort_order' => 90,
        ];
    }
}

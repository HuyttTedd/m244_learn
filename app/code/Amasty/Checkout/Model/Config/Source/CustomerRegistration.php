<?php

namespace Amasty\Checkout\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class CustomerRegistration
 */
class CustomerRegistration implements OptionSourceInterface
{
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('No')],
            ['value' => 1, 'label' => __('After Placing an Order')],
            ['value' => 2, 'label' => __('While Placing an Order')]
        ];
    }
}

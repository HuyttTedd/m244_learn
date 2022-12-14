<?php

namespace Amasty\Checkout\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class BillingAddressDisplayOptions
 */
class BillingAddressDisplayOptions implements OptionSourceInterface
{
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Payment Method'),
                'value' => 0
            ],
            [
                'label' => __('Payment Page'),
                'value' => 1
            ],
            [
                'label' => __('Below Shipping Address'),
                'value' => 2
            ]
        ];
    }
}

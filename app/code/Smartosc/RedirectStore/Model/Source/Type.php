<?php
namespace Smartosc\RedirectStore\Model\Source;

use Magento\Payment\Model\Method\AbstractMethod;

/**
 * Payment details
 */
class Type implements \Magento\Framework\Option\ArrayInterface
{
    const NORMAL = 'normal';
    const PATTERN = 'pattern';
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::NORMAL,
                'label' => 'Normal'
            ],
            [
                'value' => self::PATTERN,
                'label' => 'Pattern'
            ]
        ];
    }
}

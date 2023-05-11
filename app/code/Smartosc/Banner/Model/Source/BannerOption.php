<?php

declare(strict_types=1);

namespace Smartosc\Banner\Model\Source;

class BannerOption implements \Magento\Framework\Option\ArrayInterface
{
    const SEPARATED = 'separated';
    const SHARED = 'shared';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::SEPARATED,
                'label' => __('Separated Banner')
            ],
            [
                'value' => self::SHARED,
                'label' => __('Shared Banner')
            ]
        ];
    }
}

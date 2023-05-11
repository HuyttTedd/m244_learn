<?php

declare(strict_types=1);

namespace Amasty\ImportPro\Model\OptionSource;

use Magento\Framework\Data\OptionSourceInterface;

class JobStatus implements OptionSourceInterface
{
    public const DISABLED = '0';
    public const ENABLED = '1';

    public function toOptionArray()
    {
        $result = [];

        foreach ($this->toArray() as $value => $label) {
            $result[] = [
                'value' => $value,
                'label' => $label
            ];
        }

        return $result;
    }

    public function toArray(): array
    {
        return [
            self::DISABLED => __('Disabled'),
            self::ENABLED => __('Enabled')
        ];
    }
}

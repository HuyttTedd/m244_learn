<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Model\OptionSource;

use Magento\Framework\Data\OptionSourceInterface;

class HistoryStatus implements OptionSourceInterface
{
    public const FAILED = '0';
    public const SUCCESS = '1';

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
            self::FAILED => __('Failed'),
            self::SUCCESS => __('Success')
        ];
    }
}

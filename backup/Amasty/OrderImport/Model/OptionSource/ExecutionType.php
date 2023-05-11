<?php

declare(strict_types=1);

namespace Amasty\OrderImport\Model\OptionSource;

use Magento\Framework\Data\OptionSourceInterface;

class ExecutionType implements OptionSourceInterface
{
    public const MANUAL = 'manual';
    public const CRON = 'cron';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::MANUAL, 'label'=> __('Manual')],
            ['value' => self::CRON, 'label'=> __('Cron')]
        ];
    }
}

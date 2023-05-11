<?php
declare(strict_types=1);

namespace Amasty\ExportPro\Export\FileDestination\Type\Rest\OptionSource;

use Magento\Framework\Data\OptionSourceInterface;

class Methods implements OptionSourceInterface
{
    const POST = 0;
    const PUT = 1;

    public function toOptionArray(): array
    {
        return [
            ['value' => self::POST, 'label' => __('POST')],
            ['value' => self::PUT, 'label' => __('PUT')],
        ];
    }
}

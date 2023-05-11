<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\SourceOption\Order;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Sales\Model\Order\Config;

class OrderState implements OptionSourceInterface
{
    /**
     * @var Config
     */
    private $orderConfig;

    public function __construct(Config $orderConfig)
    {
        $this->orderConfig = $orderConfig;
    }

    public function toOptionArray(): array
    {
        $result = [];
        if ($data = $this->orderConfig->getStates()) {
            foreach ($data as $value => $label) {
                $result[] = ['value' => $value, 'label' => $label];
            }
        }

        return $result;
    }
}

<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\SourceOption\Order;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Payment\Helper\Data;

class PaymentMethodOptions implements OptionSourceInterface
{
    /**
     * @var Data
     */
    private $paymentHelper;

    public function __construct(Data $paymentHelper)
    {
        $this->paymentHelper = $paymentHelper;
    }

    public function toOptionArray(): array
    {
        $result = [];
        if ($paymentMethods = $this->paymentHelper->getPaymentMethodList()) {
            foreach ($paymentMethods as $key => $label) {
                $result[] = ['value' => $key, 'label' => $label];
            }
        }

        return $result;
    }
}

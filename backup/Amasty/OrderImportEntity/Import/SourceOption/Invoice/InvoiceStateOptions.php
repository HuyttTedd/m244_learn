<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\SourceOption\Invoice;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Sales\Model\Order\Invoice;

class InvoiceStateOptions implements OptionSourceInterface
{
    /**
     * @var Invoice
     */
    private $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function toOptionArray(): array
    {
        $result = [];
        if ($currencies = $this->invoice->getStates()) {
            foreach ($currencies as $key => $label) {
                $result[] = ['value' => $key, 'label' => $label];
            }
        }

        return $result;
    }
}

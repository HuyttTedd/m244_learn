<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\SourceOption\Order;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Directory\Model\Currency;

class CurrencyOptions implements OptionSourceInterface
{
    /**
     * @var Currency
     */
    private $currency;

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    public function toOptionArray(): array
    {
        $result = [];
        if ($currencies = $this->currency->getConfigAllowCurrencies()) {
            foreach ($currencies as $key => $currency) {
                $result[] = ['value' => $currency, 'label' => $currency];
            }
        }

        return $result;
    }
}

<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\Validation\RowValidator;

class BillingAddressRowValidator extends AddressRowValidator
{
    protected function getAddressType(): string
    {
        return 'billing';
    }
}

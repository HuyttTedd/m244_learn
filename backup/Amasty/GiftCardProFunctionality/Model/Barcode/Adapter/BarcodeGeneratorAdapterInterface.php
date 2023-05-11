<?php
declare(strict_types=1);

namespace Amasty\GiftCardProFunctionality\Model\Barcode\Adapter;

interface BarcodeGeneratorAdapterInterface
{
    /**
     * Return an HTML representation of the barcode containing the gift card code.
     *
     * @param string $giftcardCode
     * @return string
     * @throws \RuntimeException
     */
    public function getBarcode(string $giftcardCode): string;
}

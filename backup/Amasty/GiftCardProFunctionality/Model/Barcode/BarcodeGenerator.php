<?php
declare(strict_types=1);

namespace Amasty\GiftCardProFunctionality\Model\Barcode;

use Amasty\GiftCardProFunctionality\Model\Barcode\Adapter\BarcodeGeneratorAdapterInterface;
use Psr\Log\LoggerInterface;

class BarcodeGenerator
{
    /**
     * @var BarcodeGeneratorAdapterInterface
     */
    private $barcodeGeneratorAdapter;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        BarcodeGeneratorAdapterInterface $barcodeGeneratorAdapter,
        LoggerInterface $logger
    ) {
        $this->barcodeGeneratorAdapter = $barcodeGeneratorAdapter;
        $this->logger = $logger;
    }

    public function generate(string $giftcardCode): ?string
    {
        try {
            return $this->barcodeGeneratorAdapter->getBarcode($giftcardCode);
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return null;
        }
    }
}

<?php
declare(strict_types=1);

namespace Amasty\GiftCardProFunctionality\Model\Barcode\Adapter;

use Magento\Framework\ObjectManagerInterface;
use Picqer\Barcode\BarcodeGeneratorHTML;

class PicqerBarcodeAdapter implements BarcodeGeneratorAdapterInterface
{
    const DEFAULT_WIDTH_FACTOR = 1;
    const DEFAULT_HEIGHT = 30;
    const DEFAULT_FOREGROUND_COLOR = 'black';

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    public function __construct(
        ObjectManagerInterface $objectManager
    ) {
        $this->objectManager = $objectManager;
    }

    public function getBarcode(string $giftcardCode): string
    {
        if (!class_exists(BarcodeGeneratorHTML::class)) {
            throw new \RuntimeException(
                'PHP library \'picqer/php-barcode-generator\' not found.'
                . 'Please run \'composer require picqer/php-barcode-generator\' command to install it.'
            );
        }
        $generator = $this->objectManager->create(BarcodeGeneratorHTML::class);

        return $generator->getBarcode(
            $giftcardCode,
            BarcodeGeneratorHTML::TYPE_CODE_128,
            self::DEFAULT_WIDTH_FACTOR,
            self::DEFAULT_HEIGHT,
            self::DEFAULT_FOREGROUND_COLOR
        );
    }
}

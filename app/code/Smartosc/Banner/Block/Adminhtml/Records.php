<?php

declare(strict_types=1);

namespace Smartosc\Banner\Block\Adminhtml;

use Amasty\Base\Model\Serializer;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\UrlInterface;
use Magento\Payment\Model\Config as PaymentConfig;
use Smartosc\Banner\Block\Adminhtml\Config\Form\Field\Websites;
use Smartosc\Banner\Model\Source\Website as SourceWebsite;

class Records extends Field
{
    const WEBSITE_IDS = 'website_ids';
    const BANNER_FILE = 'banner_file';
    const BANNER_FILE_NAME = 'banner_file_name';
    const BACKGROUND_IMG_NONE = 'https://i.imgur.com/UWywElC.png';
    const UPLOAD_DIR = 'smartosc/banner';

    /**
     * @var EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var PaymentConfig
     */
    protected $paymentConfig;

    /**
     * @var SourceWebsite
     */
    protected $sourceWebsite;

    /**
     * @var Websites
     */
    protected $websitesRenderer;

    public function __construct(
        Context $context,
        EncoderInterface $jsonEncoder,
        Serializer $serializer,
        PaymentConfig $paymentConfig,
        SourceWebsite $sourceWebsite,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->jsonEncoder = $jsonEncoder;
        $this->serializer = $serializer;
        $this->paymentConfig = $paymentConfig;
        $this->sourceWebsite = $sourceWebsite;
    }

    protected function _construct()
    {
        $this->setTemplate('Smartosc_Banner::/records.phtml');
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    public function renderScopeLabel(AbstractElement $element)
    {
        return $this->_renderScopeLabel($element);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $this->setElement($element);

        return $this->_decorateRowHtml($element, $this->_toHtml());
    }

    /**
     * @return array
     */
    public function getSelectedConditions(): array
    {
        $conditions = $this->getElement()->getValue() ?: [];
        if (isset($conditions[0]) && empty($conditions[0])) {
            $conditions = [];
        }

        return $conditions;
    }

    /**
     * @return array
     */
    public function getDefaultConditions(): array
    {
        return [
            self::WEBSITE_IDS => $this->getWebsiteIds(),
            self::BANNER_FILE => '',
        ];
    }

    /**
     * @return array
     */
    public function getWebsiteIds(): array
    {
        return $this->sourceWebsite->toOptionArray() ?? [];
    }

    /**
     * @return bool|string
     */
    public function getInitData()
    {
        $counter = 0;
        $uploadElem = [];
        foreach ($this->getSelectedConditions() as $option) {
            $uploadElem[] = $this->escapeHtmlAttr($this->getNamePrefix(self::BANNER_FILE, $counter));
            $counter++;
        }
        return $this->serializer->serialize(
            [
                'namePrefix'        => $this->getNamePrefix('#'),
                self::WEBSITE_IDS   => $this->getWebsiteIds(),
                self::BANNER_FILE   => $this->getDefaultConditions()[self::BANNER_FILE],
                'img_upload_elem'   => $uploadElem
            ]
        );
//        {"namePrefix":"groups[auto_cancel_mode][fields][conditions][value][#]",
//         "payment_methods":{"free":"No Payment Information Required","checkmo":"Check \/ Money order","paypal_billing_agreement":"PayPal Billing Agreement",
//         "amasty_recurring_paypal":"PayPal Express Checkout","realexpayments_hpp":"Pay By Credit or Debit Card ttt"},"duration_unit":{"day":"Day(s)","hour":"Hour(s)"}}
    }

    /**
     * @param string $fileName
     * @return string
     * @throws NoSuchEntityException
     */
    public function getImgUrl(string $fileName): string
    {
        return $this->_storeManager->getStore()->getBaseUrl(
            UrlInterface::URL_TYPE_MEDIA
        ) . self::UPLOAD_DIR . '/' . $fileName;
    }

    /**
     * @param int $index
     * @param int|null $counter
     * @return string
     */
    public function getNamePrefix($index, $counter = null)
    {
        $name = str_replace('[]', '', $this->getElement()->getName());
        $name .= $counter !== null ? '[' . $counter . ']' : '';

        return $name . '[' . $index . ']';
    }
}

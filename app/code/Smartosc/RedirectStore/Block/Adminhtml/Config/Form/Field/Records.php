<?php

declare(strict_types=1);

namespace Smartosc\RedirectStore\Block\Adminhtml\Config\Form\Field;

use Amasty\Base\Model\Serializer;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Smartosc\RedirectStore\Model\Source\Website;
use Smartosc\RedirectStore\Model\Source\Type;

class Records extends Field
{
    const WEBSITE_IDS       = 'website_ids';
    const TYPE              = 'type';
    const REDIRECT_URL      = 'redirect_url';

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var Website
     */
    protected $sourceWebsite;

    /**
     * @var Type
     */
    protected $sourceType;

    /**
     * Records constructor.
     * @param Context $context
     * @param Serializer $serializer
     * @param Website $sourceWebsite
     * @param Type $sourceType
     * @param array $data
     */
    public function __construct(
        Context $context,
        Serializer $serializer,
        Website $sourceWebsite,
        Type $sourceType,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->serializer           = $serializer;
        $this->sourceWebsite        = $sourceWebsite;
        $this->sourceType           = $sourceType;
    }

    protected function _construct()
    {
        $this->setTemplate('Smartosc_RedirectStore::/records.phtml');
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
    public function getSelectedRecords(): array
    {
        $records = $this->getElement()->getValue() ?: [];
        if (isset($records[0]) && empty($records[0])) {
            $records = [];
        }

        return $records;
    }

    /**
     * @return array
     */
    public function getDefaultRecords(): array
    {
        return [
            self::WEBSITE_IDS => $this->getWebsites(),
            self::TYPE => $this->getType(),
            self::REDIRECT_URL => '',
        ];
    }

    /**
     * @return array
     */
    public function getWebsites(): array
    {
        return $this->sourceWebsite->toOptionArray() ?? [];
    }

    /**
     * @return array
     */
    public function getType(): array
    {
        return $this->sourceType->toOptionArray() ?? [];
    }

    /**
     * @return bool|string
     */
    public function getInitData()
    {
        return $this->serializer->serialize(
            [
                'namePrefix'            => $this->getNamePrefix('#'),
                self::WEBSITE_IDS       => $this->getWebsites(),
                self::TYPE              => $this->getType(),
            ]
        );
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

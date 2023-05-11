<?php

declare(strict_types=1);

namespace Smartosc\Banner\Block\Adminhtml\Config\Form\Field;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;
use Smartosc\Banner\Model\Source\Website as SourceWebsite;

/**
 * HTML select for websites
 */
class Websites extends Select
{
    /** @var SourceWebsite */
    protected $sourceWebsite;

    /**
     * @param Context $context
     * @param SourceWebsite $sourceWebsite
     * @param array $data
     */
    public function __construct(Context $context, SourceWebsite $sourceWebsite, array $data = [])
    {
        parent::__construct($context, $data);
        $this->sourceWebsite = $sourceWebsite;
    }

    /**
     * Get country options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->sourceWebsite->toOptionArray();
    }

    /**
     * Sets name for input element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setData('name', $value);
    }
}

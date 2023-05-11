<?php

namespace Amasty\Blog\Block\Layout;

/**
 * Class
 */
class AbstractClass extends \Magento\Framework\View\Element\Template
{
    /**
     * @return bool|\Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getHead()
    {
        return $this->getLayout()->getBlock('head');
    }

    /**
     * @return bool|\Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getExtraHead()
    {
        return $this->getLayout()->getBlock('extra_head');
    }
}

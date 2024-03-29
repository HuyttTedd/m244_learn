<?php

declare(strict_types=1);

namespace Amasty\OrderImport\Block\Adminhtml\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DuplicateButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        if (!$this->getProfileId() || $this->isDuplicate()) {
            return [];
        }
        return [
            'label' => __('Duplicate'),
            'class' => 'duplicate',
            'on_click' => sprintf("location.href = '%s';", $this->getDuplicateUrl()),
            'sort_order' => 40
        ];
    }

    public function getDuplicateUrl()
    {
        return $this->getUrl('*/*/duplicate', ['id' => $this->getProfileId()]);
    }
}

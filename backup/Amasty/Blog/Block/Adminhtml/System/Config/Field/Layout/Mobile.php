<?php

namespace Amasty\Blog\Block\Adminhtml\System\Config\Field\Layout;

class Mobile extends \Amasty\Blog\Block\Adminhtml\System\Config\Field\Layout
{
    protected function getLayouts(): array
    {
        return $this->layoutOptions->getMobileOptions();
    }
}

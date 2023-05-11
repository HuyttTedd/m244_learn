<?php

namespace Amasty\Blog\Block\Adminhtml\Tags\Edit;

use Amasty\Blog\Controller\Adminhtml\Tags\Edit;

class DeleteButton extends \Amasty\Blog\Block\Adminhtml\DeleteButton
{
    /**
     * @return int
     */
    public function getItemId()
    {
        return (int)$this->getRegistry()->registry(Edit::CURRENT_AMASTY_BLOG_TAG)->getTagId();
    }
}

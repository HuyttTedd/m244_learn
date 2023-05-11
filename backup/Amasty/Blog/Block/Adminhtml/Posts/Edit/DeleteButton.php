<?php

namespace Amasty\Blog\Block\Adminhtml\Posts\Edit;

use Amasty\Blog\Controller\Adminhtml\Posts\Edit;

class DeleteButton extends \Amasty\Blog\Block\Adminhtml\DeleteButton
{
    /**
     * @return int
     */
    public function getItemId()
    {
        return (int)$this->getRegistry()->registry(Edit::CURRENT_AMASTY_BLOG_POST)->getPostId();
    }
}

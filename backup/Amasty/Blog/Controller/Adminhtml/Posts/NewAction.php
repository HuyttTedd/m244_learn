<?php

namespace Amasty\Blog\Controller\Adminhtml\Posts;

/**
 * Class NewAction
 */
class NewAction extends \Amasty\Blog\Controller\Adminhtml\Posts
{
    public function execute()
    {
        $this->_forward('edit');
    }
}

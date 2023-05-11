<?php

declare(strict_types=1);

namespace Amasty\Blog\Controller\AbstractController;

use Magento\Framework\App\Action\Action;

class Redirect extends Action
{
    public function execute()
    {
        $url = $this->getRequest()->getParam('url');
        if ($url) {
            $this->getResponse()->setRedirect($url, 301)->sendHeaders();
        }
    }
}

<?php

namespace Amasty\OrderImport\Controller\Adminhtml\History;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_OrderImport::order_import_history';

    /**
     * Index action
     *
     * @return Page
     */
    public function execute()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Amasty_OrderImport::order_import_history');
        $resultPage->getConfig()->getTitle()->prepend(__('Import History'));
        $resultPage->addBreadcrumb(__('Import History'), __('Import History'));

        return $resultPage;
    }
}

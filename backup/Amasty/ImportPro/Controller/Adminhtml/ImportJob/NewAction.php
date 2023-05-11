<?php

namespace Amasty\ImportPro\Controller\Adminhtml\ImportJob;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_ImportPro::import_job_create';

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Amasty_ImportPro::importcron');
        $resultPage->getConfig()->getTitle()->prepend(__('New Import Cron Job'));
        $resultPage->addBreadcrumb(__('New Import Cron Job'), __('New Import Cron Job'));

        return $resultPage;
    }
}

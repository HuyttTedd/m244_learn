<?php

namespace Amasty\ImportPro\Controller\Adminhtml\ImportJob;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_ImportPro::import_job_view';

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
        $resultPage->getConfig()->getTitle()->prepend(__('Import Cron Jobs'));
        $resultPage->addBreadcrumb(__('Import Cron Jobs'), __('Import Cron Jobs'));

        return $resultPage;
    }
}

<?php

namespace Amasty\ImportPro\Controller\Adminhtml\ImportJob;

use Amasty\ImportPro\Api\CronJobRepositoryInterface;
use Amasty\ImportPro\Model\Job\Job;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_ImportPro::import_job_edit';

    /**
     * @var CronJobRepositoryInterface
     */
    private $repository;

    public function __construct(
        CronJobRepositoryInterface $repository,
        Action\Context $context
    ) {
        parent::__construct($context);
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Amasty_ImportPro::importcron');

        if ($jobId = (int)$this->getRequest()->getParam(Job::JOB_ID)) {
            try {
                $this->repository->getById($jobId);
                $resultPage->getConfig()->getTitle()->prepend(__('Edit Job'));
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('This job no longer exists.'));

                return $this->resultRedirectFactory->create()->setPath('*/*/index');
            }
        } else {
            $resultPage->getConfig()->getTitle()->prepend(__('New Import Job'));
        }

        return $resultPage;
    }
}

<?php

namespace Amasty\ImportPro\Controller\Adminhtml\ImportJob;

use Amasty\ImportPro\Api\CronJobRepositoryInterface;
use Amasty\ImportPro\Model\Job\Job;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Delete extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_ImportPro::import_job_delete';

    /**
     * @var CronJobRepositoryInterface
     */
    private $repository;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        CronJobRepositoryInterface $repository,
        Action\Context $context,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->repository = $repository;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam(Job::JOB_ID);

        if ($id) {
            try {
                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You have successfully deleted the job'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('We can\'t delete item right now. Please review the log and try again.')
                );
                $this->logger->critical($e);
            }
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}

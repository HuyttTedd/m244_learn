<?php

namespace Amasty\ImportPro\Controller\Adminhtml\ImportJob;

use Amasty\ImportPro\Model\Job\Repository;
use Amasty\ImportPro\Model\Job\ResourceModel\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_ImportPro::import_job_delete';

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $jobCollectionFactory;

    /**
     * @var Repository
     */
    private $repository;

    public function __construct(
        Filter $filter,
        Action\Context $context,
        CollectionFactory $jobCollectionFactory,
        Repository $repository
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->jobCollectionFactory = $jobCollectionFactory;
        $this->repository = $repository;
    }

    public function execute()
    {
        $this->filter->applySelectionOnTargetProvider();
        /** @var \Amasty\ImportPro\Model\Job\ResourceModel\Collection $collection */
        $collection = $this->filter->getCollection($this->jobCollectionFactory->create());

        if ($collection->getSize()) {
            foreach ($collection->getItems() as $job) {
                try {
                    $this->repository->delete($job);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }
        }

        $this->messageManager->addSuccessMessage(__('Cron jobs was successfully removed.'));

        return $this->resultRedirectFactory->create()->setPath('*/*');
    }
}

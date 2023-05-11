<?php

declare(strict_types=1);

namespace Amasty\OrderImport\Controller\Adminhtml\Profile;

use Amasty\ImportPro\Model\History\Repository;
use Amasty\OrderImport\Api\ProfileRepositoryInterface;
use Amasty\OrderImport\Model\Profile\Profile;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;

class Delete extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_OrderImport::order_import_profiles';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ProfileRepositoryInterface
     */
    private $repository;

    /**
     * @var Repository
     */
    private $historyRepository;

    public function __construct(
        Action\Context $context,
        ProfileRepositoryInterface $repository,
        Repository $historyRepository,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->logger = $logger;
        $this->repository = $repository;
        $this->historyRepository = $historyRepository;
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam(Profile::ID);

        if ($id) {
            try {
//                $this->historyRepository->clearByJobTypeAndId(ModuleType::TYPE, $id);
                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('The profile has been deleted.'));

                return $this->resultRedirectFactory->create()->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    __('Can\'t delete the profile right now. Please review the log and try again.')
                );
                $this->logger->critical($e);
            }

            return $this->resultRedirectFactory->create()->setPath('*/*/edit', [Profile::ID => $id]);
        } else {
            $this->messageManager->addErrorMessage(__('Can\'t find a resolution to delete.'));
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}

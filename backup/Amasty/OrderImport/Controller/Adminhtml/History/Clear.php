<?php

namespace Amasty\OrderImport\Controller\Adminhtml\History;

use Amasty\ImportPro\Model\History\Repository;
use Amasty\OrderImport\Model\ModuleType;
use Magento\Backend\App\Action;

class Clear extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_OrderImport::order_import_history';

    /**
     * @var Repository
     */
    private $repository;

    public function __construct(
        Action\Context $context,
        Repository $repository
    ) {
        parent::__construct($context);
        $this->repository = $repository;
    }

    public function execute()
    {
        $result = $this->repository->clearHistory(ModuleType::TYPE);

        if ($result) {
            $this->messageManager->addSuccessMessage(__("History has been cleared."));
        } else {
            $this->messageManager->addErrorMessage(__("Something went wrong."));
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}

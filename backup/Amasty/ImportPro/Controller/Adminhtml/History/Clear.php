<?php

namespace Amasty\ImportPro\Controller\Adminhtml\History;

use Amasty\ImportPro\Model\History\Repository;
use Magento\Backend\App\Action;

class Clear extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_ImportPro::import_history_clear';

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
        $result = $this->repository->clearHistory();

        if ($result) {
            $this->messageManager->addSuccessMessage(__("History has been cleared."));
        } else {
            $this->messageManager->addErrorMessage(__("Something went wrong."));
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/');
    }
}

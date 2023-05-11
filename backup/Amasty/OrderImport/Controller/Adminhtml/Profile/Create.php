<?php

declare(strict_types=1);

namespace Amasty\OrderImport\Controller\Adminhtml\Profile;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;

class Create extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_OrderImport::order_import_profiles';

    /**
     * @var ForwardFactory
     */
    private $resultForwardFactory;

    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context);
        $this->resultForwardFactory = $resultForwardFactory;
    }

    public function execute()
    {
        $this->resultForwardFactory->create()->forward('edit');
    }
}

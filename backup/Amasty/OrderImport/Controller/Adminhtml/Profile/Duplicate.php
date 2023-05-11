<?php

declare(strict_types=1);

namespace Amasty\OrderImport\Controller\Adminhtml\Profile;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;

class Duplicate extends Action
{
    public const ADMIN_RESOURCE = 'Amasty_OrderImport::order_import_profiles';

    public const REQUEST_PARAM_NAME = 'duplicate';

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
        $this->resultForwardFactory->create()
            ->setParams([self::REQUEST_PARAM_NAME => true])
            ->forward('edit');
    }
}

<?php

namespace Amasty\Fpc\Plugin;

use Amasty\Fpc\Model\PageStatus;

class ActionInterface
{
    /**
     * @var PageStatus
     */
    private $pageStatus;

    public function __construct(
        PageStatus $pageStatus
    ) {
        $this->pageStatus = $pageStatus;
    }

    public function beforeExecute(
        \Magento\Framework\App\ActionInterface $subject
    ) {
        $this->pageStatus->setStatus(PageStatus::STATUS_MISS);
    }
}
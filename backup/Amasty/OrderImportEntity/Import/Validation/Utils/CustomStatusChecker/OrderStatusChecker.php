<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\Validation\Utils\CustomStatusChecker;

use Amasty\OrderStatus\Model\StatusResolver;
use Magento\Framework\ObjectManagerInterface;

class OrderStatusChecker implements CustomStatusCheckerInterface
{
    /**
     * @var StatusResolver|null
     */
    private $statusResolver = null;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        if (class_exists(StatusResolver::class)) {
            $this->statusResolver = $objectManager->get(StatusResolver::class);
        }
    }

    public function check(string $status, string $state = ''): bool
    {
        if ($this->statusResolver) {
            return (bool)$this->statusResolver->getStatusId($status);
        }

        return false;
    }
}

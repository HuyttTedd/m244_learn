<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\Validation\RowValidator;

use Amasty\ImportCore\Api\Validation\RowValidatorInterface;
use Amasty\ImportCore\Import\Utils\DuplicateFieldChecker;
use Amasty\OrderImportEntity\Import\Validation\Utils\CustomStatusCheckApplier;
use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory;

class OrderRowValidator implements RowValidatorInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var array
     */
    private $statusStateMapping;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @var DuplicateFieldChecker
     */
    private $duplicateFieldChecker;

    /**
     * @var CustomStatusCheckApplier
     */
    private $customStatusCheckApplier;

    public function __construct(
        CollectionFactory $collectionFactory,
        DuplicateFieldChecker $duplicateFieldChecker,
        CustomStatusCheckApplier $customStatusCheckApplier
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->duplicateFieldChecker = $duplicateFieldChecker;
        $this->customStatusCheckApplier = $customStatusCheckApplier;
    }

    public function validate(array $row): bool
    {
        $this->message = null;

        if ($this->duplicateFieldChecker->hasDuplicateFields('sales_order', $row)) {
            $this->message = __('A duplicate field was found in order entity.')->render();

            return false;
        }

        if ($this->hasStatusAndState($row)
            && !$this->isStatusMatchState($row)
        ) {
            $this->message = __('The status value doesn\'t correspond to the state.')->render();

            return false;
        }

        if (!$this->validateVirtualOrder($row)) {
            $this->message = __('Virtual orders can\'t have shipping address.')->render();
        }

        return true;
    }

    /**
     * Determines if specified row has 'status' and 'state' values
     *
     * @param array $row
     * @return bool
     */
    private function hasStatusAndState(array $row)
    {
        return isset($row['state']) && isset($row['status']);
    }

    private function isStatusMatchState(array $row): bool
    {
        if (!empty($this->statusStateMapping[$row['state']][$row['status']])) {
            return $this->statusStateMapping[$row['state']][$row['status']];
        }

        return $this->statusStateMapping[$row['state']][$row['status']] =
            $this->isStateStatusExists((string)$row['state'], (string)$row['status'])
            || $this->customStatusCheckApplier->apply((string)$row['status'], (string)$row['state']);
    }

    private function validateVirtualOrder(array $row): bool
    {
        if (isset($row['is_virtual']) && isset($row['shipping_address_id']) && $row['is_virtual'] == 1) {
            return false;
        }

        return true;
    }

    private function isStateStatusExists(string $state, string $status): bool
    {
        return (bool)$this->collectionFactory->create()
            ->addStateFilter($state)
            ->addFieldToFilter('main_table.status', $status)
            ->getSize();
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}

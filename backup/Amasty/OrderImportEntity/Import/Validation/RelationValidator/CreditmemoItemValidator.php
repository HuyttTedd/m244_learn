<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\Validation\RelationValidator;

use Amasty\ImportCore\Api\Validation\RelationValidatorInterface;

class CreditmemoItemValidator implements RelationValidatorInterface
{
    /**
     * @var string|null
     */
    private $message;

    public function validate(array $entityRow, array $subEntityRows): bool
    {
        if (!$this->validateItemsQty($entityRow, $subEntityRows)) {
            $this->message = __(
                'Wrong creditmemo_items qty specified for creditmemo %1',
                $entityRow['entity_id'] ?? ''
            )->render();

            return false;
        }

        return true;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    private function validateItemsQty(array $entityRow, array $subEntityRows): bool
    {
        if (!isset($entityRow['total_qty'])) {
            return true;
        }
        $itemsQty = .0;

        foreach ($subEntityRows as $row) {
            $itemsQty += (float)($row['qty'] ?? 0);
        }

        return $itemsQty === (float)$entityRow['total_qty'];
    }
}

<?php

declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\Validation\EntityValidator;

use Amasty\ImportCore\Api\Validation\FieldValidatorInterface;
use Amasty\OrderImportEntity\Import\Validation\Utils\CustomStatusCheckApplier;
use Magento\Framework\App\ResourceConnection;

class Status implements FieldValidatorInterface
{
    /**
     * @var ResourceConnection
     */
    private $connection;

    /**
     * @var CustomStatusCheckApplier
     */
    private $customStatusCheckApplier;

    /**
     * @var array
     */
    private $validationResult = [];

    public function __construct(
        ResourceConnection $connection,
        CustomStatusCheckApplier $customStatusCheckApplier
    ) {
        $this->connection = $connection;
        $this->customStatusCheckApplier = $customStatusCheckApplier;
    }

    public function validate(array $row, string $field): bool
    {
        if (isset($row[$field])) {
            $status = trim($row[$field]);

            if (!empty($status)) {
                if (!isset($this->validationResult[$status])) {
                    $this->validationResult[$status] = $this->isStatusExists($status)
                        || $this->customStatusCheckApplier->apply($status);
                }

                return $this->validationResult[$status];
            }
        }

        return true;
    }

    private function isStatusExists(string $status): bool
    {
        $statusTable = $this->connection->getTableName('sales_order_status');
        $connection = $this->connection->getConnection();

        return (bool)$connection->fetchOne(
            $connection->select()
                ->from($statusTable)
                ->where('status = ?', trim($status))
                ->limit(1)
                ->columns(['status'])
        );
    }
}

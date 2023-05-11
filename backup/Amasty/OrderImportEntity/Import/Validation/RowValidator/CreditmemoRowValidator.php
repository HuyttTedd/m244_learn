<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\Validation\RowValidator;

use Amasty\ImportCore\Api\Validation\RowValidatorInterface;
use Amasty\ImportCore\Import\Utils\DuplicateFieldChecker;

class CreditmemoRowValidator implements RowValidatorInterface
{
    /**
     * @var string|null
     */
    private $message;

    /**
     * @var DuplicateFieldChecker
     */
    private $duplicateFieldChecker;

    public function __construct(
        DuplicateFieldChecker $duplicateFieldChecker
    ) {
        $this->duplicateFieldChecker = $duplicateFieldChecker;
    }

    public function validate(array $row): bool
    {
        $this->message = null;

        if ($this->duplicateFieldChecker->hasDuplicateFields('sales_creditmemo', $row)) {
            $this->message = __('A duplicate field was found in creditmemo entity.')->render();

            return false;
        }

        return true;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}

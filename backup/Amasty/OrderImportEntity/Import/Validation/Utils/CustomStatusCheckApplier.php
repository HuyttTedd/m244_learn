<?php
declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\Validation\Utils;

use Amasty\OrderImportEntity\Import\Validation\Utils\CustomStatusChecker\CustomStatusCheckerInterface;

class CustomStatusCheckApplier
{
    /**
     * @var CustomStatusCheckerInterface[]
     */
    private $checkers = [];

    public function __construct(
        array $checkers = []
    ) {
        $this->initializeCustomCheckers($checkers);
    }

    public function apply(string $status, string $state = ''): bool
    {
        foreach ($this->checkers as $checker) {
            if ($checker->check($status, $state)) {
                return true;
            }
        }

        return false;
    }

    private function initializeCustomCheckers(array $checkers): void
    {
        foreach ($checkers as $name => $checker) {
            if (!$checker instanceof CustomStatusCheckerInterface) {
                throw new \LogicException(
                    sprintf(
                        'Custom Status Checker "%s" must implement %s',
                        $name,
                        CustomStatusCheckerInterface::class
                    )
                );
            }
        }

        $this->checkers = $checkers;
    }
}

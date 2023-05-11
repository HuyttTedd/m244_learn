<?php

declare(strict_types=1);

namespace Amasty\OrderImportEntity\Import\Validation\Utils\CustomStatusChecker;

interface CustomStatusCheckerInterface
{
    /**
     * Checks the existence of a custom order state with status
     *
     * @param string $status
     * @param string $state
     *
     * @return bool
     */
    public function check(string $status, string $state = ''): bool;
}

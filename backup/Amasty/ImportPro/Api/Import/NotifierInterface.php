<?php

namespace Amasty\ImportPro\Api\Import;

use Amasty\ImportCore\Api\ImportProcessInterface;

interface NotifierInterface
{
    /**
     * Perform notification process.
     *
     * @param ImportProcessInterface $importProcess
     */
    public function notify(ImportProcessInterface $importProcess): void;
}

<?php

namespace Amasty\ExportPro\Api\Export;

use Amasty\ExportCore\Api\ExportProcessInterface;

interface NotifierInterface
{
    /**
     * Perform notification process.
     *
     * @param ExportProcessInterface $exportProcess
     */
    public function notify(ExportProcessInterface $exportProcess): void;
}

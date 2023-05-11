<?php
declare(strict_types=1);

namespace Amasty\ExportPro\Export\FileDestination\Type\Rest\Auth;

use Amasty\ExportCore\Api\ExportProcessInterface;
use Magento\Framework\HTTP\ClientInterface;

interface AuthInterface
{
    /**
     * @param ExportProcessInterface $exportProcess
     * @param ClientInterface $curl
     *
     * @return void
     */
    public function process(ExportProcessInterface  $exportProcess, ClientInterface $curl);
}

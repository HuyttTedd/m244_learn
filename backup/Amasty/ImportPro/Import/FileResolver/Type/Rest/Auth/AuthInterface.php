<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\FileResolver\Type\Rest\Auth;

use Amasty\ImportCore\Api\ImportProcessInterface;
use Magento\Framework\HTTP\ClientInterface;

interface AuthInterface
{
    /**
     * @param ImportProcessInterface $importProcess
     * @param ClientInterface $curl
     *
     * @return void
     */
    public function process(ImportProcessInterface $importProcess, ClientInterface $curl);
}

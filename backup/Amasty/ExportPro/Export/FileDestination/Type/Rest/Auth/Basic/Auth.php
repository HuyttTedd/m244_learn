<?php
declare(strict_types=1);

namespace Amasty\ExportPro\Export\FileDestination\Type\Rest\Auth\Basic;

use Amasty\ExportCore\Api\ExportProcessInterface;
use Amasty\ExportPro\Export\FileDestination\Type\Rest\Auth\AuthInterface;
use Magento\Framework\HTTP\ClientInterface;

class Auth implements AuthInterface
{
    public function process(ExportProcessInterface $exportProcess, ClientInterface $curl)
    {
        if ($exportProcess->getProfileConfig()->getExtensionAttributes()->getRestFileDestination()
            && ($config = $exportProcess->getProfileConfig()->getExtensionAttributes()
                ->getRestFileDestination()->getExtensionAttributes()->getBasic())
        ) {
            $curl->setCredentials($config->getUsername(), $config->getPassword());
        }
    }
}

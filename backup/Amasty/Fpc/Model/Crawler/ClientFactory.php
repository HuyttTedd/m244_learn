<?php

declare(strict_types=1);

namespace Amasty\Fpc\Model\Crawler;

use Amasty\Fpc\Model\Config;
use Amasty\Fpc\Model\Crawler\HttpClient;
use Magento\Framework\ObjectManagerInterface;

class ClientFactory
{
    /**
     * @var Config
     */
    private $configProvider;

    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    public function __construct(
        Config $configProvider,
        ObjectManagerInterface $objectManager
    ) {
        $this->configProvider = $configProvider;
        $this->objectManager = $objectManager;
    }

    public function create(): HttpClient\CrawlerClientInterface
    {
        if ($this->configProvider->isMultipleCurl() && $this->configProvider->getProcessesNumber() > 1) {
            return $this->objectManager->create(HttpClient\AsyncClient::class);
        }

        return $this->objectManager->create(HttpClient\Client::class);
    }
}

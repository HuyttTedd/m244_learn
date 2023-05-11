<?php

declare(strict_types=1);

namespace Smartosc\Banner\ViewModel;

use Amasty\Base\Model\Serializer;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;
use Smartosc\Banner\Model\Configuration;

/**
 * Class BannerData.
 */
class BannerData implements ArgumentInterface
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param Configuration $configuration
     * @param Serializer $serializer
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Configuration $configuration,
        Serializer $serializer,
        StoreManagerInterface $storeManager
    ) {
        $this->configuration = $configuration;
        $this->serializer = $serializer;
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     */
    public function getBannerOption(): string
    {
        return $this->configuration->getBannerOption();
    }

    /**
     * @return string
     */
    public function getSharedBannerUrl(): string
    {
        return $this->configuration->getSharedBannerUrl();
    }

    /**
     * @return string
     */
    public function getBannerUrlForCurrentStore(): string
    {
        $currentWebsiteId = $this->storeManager->getWebsite()->getId();
        $mapping = $this->serializer->unserialize($this->configuration->getBannerStoreMapping());

        return $mapping[$currentWebsiteId] ?? '';
    }

    /**
     * @return bool
     */
    public function isEnabledBanner(): bool
    {
        return $this->configuration->isBannerEnabled();
    }
}

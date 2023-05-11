<?php

declare(strict_types=1);

namespace Smartosc\Banner\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Configuration.
 */
class Configuration
{
    const XML_PATH_BANNER_GENERAL_ENABLED       = 'smartosc_banner/general/enabled';
    const XML_PATH_BANNER_GENERAL_OPTION        = 'smartosc_banner/general/banner_option';
    const XML_PATH_BANNER_STORE_MAPPING         = 'smartosc_banner/general/banner_for_store';
    const XML_PATH_SHARED_BANNER_URL            = 'smartosc_banner/general/shared_url';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var array
     */
    protected $caches = [];

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isBannerEnabled(): bool
    {
        if (!isset($this->caches[self::XML_PATH_BANNER_GENERAL_ENABLED])) {
            $this->caches[self::XML_PATH_BANNER_GENERAL_ENABLED] = $this->scopeConfig->isSetFlag(
                self::XML_PATH_BANNER_GENERAL_ENABLED
            );
        }

        return $this->caches[self::XML_PATH_BANNER_GENERAL_ENABLED];
    }

    /**
     * @return string
     */
    public function getBannerOption(): string
    {
        if (!isset($this->caches[self::XML_PATH_BANNER_GENERAL_OPTION])) {
            $this->caches[self::XML_PATH_BANNER_GENERAL_OPTION] = $this->scopeConfig->getValue(
                self::XML_PATH_BANNER_GENERAL_OPTION
            );
        }

        return $this->caches[self::XML_PATH_BANNER_GENERAL_OPTION];
    }

    /**
     * @return string
     */
    public function getSharedBannerUrl(): string
    {
        if (!isset($this->caches[self::XML_PATH_SHARED_BANNER_URL])) {
            $this->caches[self::XML_PATH_SHARED_BANNER_URL] = $this->scopeConfig->getValue(
                self::XML_PATH_SHARED_BANNER_URL
            );
        }

        return $this->caches[self::XML_PATH_SHARED_BANNER_URL];
    }

    /**
     * @return string
     */
    public function getBannerStoreMapping(): string
    {
        if (!isset($this->caches[self::XML_PATH_BANNER_STORE_MAPPING])) {
            $this->caches[self::XML_PATH_BANNER_STORE_MAPPING] = $this->scopeConfig->getValue(
                self::XML_PATH_BANNER_STORE_MAPPING
            );
        }

        return $this->caches[self::XML_PATH_BANNER_STORE_MAPPING];
    }
}

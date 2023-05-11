<?php

declare(strict_types=1);

namespace Smartosc\RedirectStore\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Configuration.
 */
class Configuration
{
    const XML_PATH_REDIRECT_STORE_GENERAL_ENABLED = 'smartosc_redirectstore/general/enabled';
    const XML_PATH_REDIRECT_STORE_URL = 'smartosc_redirectstore/general/redirect_url';

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
     * @param string $websiteCode
     * @return bool
     */
    public function isRedirectStoreEnabled(string $websiteCode): bool
    {
        if (!isset($this->caches[self::XML_PATH_REDIRECT_STORE_GENERAL_ENABLED])) {
            $this->caches[self::XML_PATH_REDIRECT_STORE_GENERAL_ENABLED] = $this->scopeConfig->isSetFlag(
                self::XML_PATH_REDIRECT_STORE_GENERAL_ENABLED, ScopeInterface::SCOPE_WEBSITE, $websiteCode
            );
        }

        return $this->caches[self::XML_PATH_REDIRECT_STORE_GENERAL_ENABLED];
    }

    /**
     * @param string $websiteCode
     * @return string
     */
    public function getRedirectUrl(string $websiteCode): string
    {
        if (!isset($this->caches[self::XML_PATH_REDIRECT_STORE_URL])) {
            $this->caches[self::XML_PATH_REDIRECT_STORE_URL] = $this->scopeConfig->getValue(
                self::XML_PATH_REDIRECT_STORE_URL,
                ScopeInterface::SCOPE_WEBSITE,
                $websiteCode
            );
        }

        return $this->caches[self::XML_PATH_REDIRECT_STORE_URL];
    }
}

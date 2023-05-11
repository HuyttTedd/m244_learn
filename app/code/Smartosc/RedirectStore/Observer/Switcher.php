<?php

declare(strict_types=1);

namespace Smartosc\RedirectStore\Observer;

use Magento\Framework\App\Request\Http as RequestHttp;
use Magento\Framework\App\Request\PathInfo;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Validation\StoreCodeValidator;
use Smartosc\RedirectStore\Model\Configuration;

class Switcher implements ObserverInterface
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var RequestHttp
     */
    private $request;

    /**
     * @var PathInfo
     */
    private $pathInfo;

    /**
     * @var StoreCodeValidator
     */
    private $storeCodeValidator;

    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var Http
     */
    private $http;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @var \Magento\Framework\App\ResponseFactory
     */
    private $responseFactory;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;

    /**
     * @param Configuration $configuration
     * @param StoreManagerInterface $storeManager
     * @param RequestHttp $request
     * @param PathInfo $pathInfo
     * @param Http $http
     * @param StoreCodeValidator $storeCodeValidator
     * @param ResultFactory $resultFactory
     * @param StoreRepositoryInterface $storeRepository
     */
    public function __construct(
        Configuration $configuration,
        StoreManagerInterface $storeManager,
        RequestHttp $request,
        PathInfo $pathInfo,
        Http $http,
        StoreCodeValidator $storeCodeValidator,
        ResultFactory $resultFactory,
        StoreRepositoryInterface $storeRepository,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url
    )
    {
        $this->configuration = $configuration;
        $this->storeManager = $storeManager;
        $this->request = $request;
        $this->http = $http;
        $this->pathInfo = $pathInfo;
        $this->storeCodeValidator = $storeCodeValidator;
        $this->resultFactory = $resultFactory;
        $this->storeRepository = $storeRepository;
        $this->responseFactory = $responseFactory;
        $this->url = $url;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        return;
        /** @var ResponseInterface $response */
        $action = $observer->getData('controller_action');
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/logg.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('aaa');
        $logger->info($this->request->getRequestUri());
        $logger->info($this->request->getBaseUrl());
        $logger->info($this->storeManager->getStore()->getCurrentUrl());
        $logger->info('end');

        if (stristr($this->request->getRequestUri(), 'jwt/validate')) {
            return;
        }
        $uri = $this->request->getRequestUri();
        $uriArr = str_split($uri);
        if (count($uriArr) > 2 && $uriArr[0] == '/' && $uriArr[count($uriArr) - 1] == '/' && $this->checkStoreCode($uriArr)) {
//            array_pop($uriArr);
//            $uri = implode("", $uriArr);
//            $logger->info($uri);
//            $logger->info('------------------------------------');
//            $redirectionUrl = $this->url->getUrl($uri);
//            $this->responseFactory->create()->setRedirect($redirectionUrl)->sendResponse();
//            return $this;
        }
        $pathInfo = $this->pathInfo->getPathInfo($this->request->getRequestUri(), $this->request->getBaseUrl());
        $storeCode = $this->getStoreCode($pathInfo);
        if (empty($storeCode) || $storeCode === Store::ADMIN_CODE || !$this->storeCodeValidator->isValid($storeCode)) {
            return;
        }
        try {
            $storeId = $this->storeRepository->get($storeCode)->getId();
            $websiteId = $this->storeManager->getStore($storeId)->getWebsiteId();
            $websiteCode = $this->storeManager->getWebsite($websiteId)->getCode();
        } catch (NoSuchEntityException $e) {
            return;
        }
        if ($this->configuration->isRedirectStoreEnabled($websiteCode)) {
            $url = $this->configuration->getRedirectUrl($websiteCode);
            $this->http->setRedirect($url);
        }
    }

    /**
     * Check if uri like /par_en/, /rom_en/...
     *
     * @param array $uri
     * @return bool
     */
    private function checkStoreCode(array $uri)
    {
        for ($i = 1; $uri < count($uri) - 1; $i++) {
            if (stristr($uri[$i], '/')) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get store code from path info string
     *
     * @param string $pathInfo
     * @return string
     */
    private function getStoreCode(string $pathInfo) : string
    {
        $pathParts = explode('/', ltrim($pathInfo, '/'), 2);
        return current($pathParts);
    }
}

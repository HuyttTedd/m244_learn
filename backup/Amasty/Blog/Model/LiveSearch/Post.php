<?php

declare(strict_types=1);

namespace Amasty\Blog\Model\LiveSearch;

use Amasty\Blog\Model\ResourceModel\Posts\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class Post implements LiveSearchInterface
{
    public const SEARCH_FIELD = 'store.title';

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
    }

    public function getSearchResult(string $query, int $itemsLimit): array
    {
        $result = [];
        $collection = $this->collectionFactory->create();
        $collection->addFilterByStatus();
        $collection->addStoreWithDefault((int)$this->storeManager->getStore()->getId());
        $collection->setQueryText($query);
        $collection->setLimit($itemsLimit);
        foreach ($collection as $item) {
            $result[] = [
                'title' => $item->getTitle(),
                'url' => $item->getUrl()
            ];
        }

        return $result;
    }
}

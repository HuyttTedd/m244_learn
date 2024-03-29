<?php

declare(strict_types=1);

namespace Amasty\Blog\Model\LiveSearch;

use Amasty\Blog\Model\ResourceModel\Tag\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class Tag implements LiveSearchInterface
{
    public const SEARCH_FIELD = 'store.name';

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
        $collection = $this->collectionFactory->create();
        $collection->addStoreWithDefault((int)$this->storeManager->getStore()->getId());
        $collection->setQueryText($query);
        $collection->setLimit($itemsLimit);
        $result = [];
        foreach ($collection as $item) {
            $result[] = [
                'title' => $item->getName(),
                'url' => $item->getUrl()
            ];
        }

        return $result;
    }
}

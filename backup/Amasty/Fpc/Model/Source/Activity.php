<?php

namespace Amasty\Fpc\Model\Source;

use Amasty\Fpc\Model\ResourceModel\Activity\CollectionFactory;

class Activity implements SourceInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Return pages to crawl
     *
     * @param int    $queueLimit
     * @param string $eMessage
     *
     * @return array
     */
    public function getPages($queueLimit, $eMessage)
    {
        $activityCollection = $this->collectionFactory->create();

        return $activityCollection->getPagesData($queueLimit);
    }
}

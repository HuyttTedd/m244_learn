<?php

declare(strict_types=1);

namespace Amasty\OrderImport\Ui\DataProvider\Profile;

use Amasty\OrderImport\Model\Profile\ResourceModel\CollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class Listing extends AbstractDataProvider
{
    /**
     * @var UrlInterface
     */
    private $url;

    public function __construct(
        CollectionFactory $collectionFactory,
        UrlInterface $url,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->url = $url;
    }
}

<?php

declare(strict_types=1);

namespace Amasty\Blog\Model\Posts\RelatedProducts\Products;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;

class AddBasicAttributesModifier implements CollectionModifierInterface
{
    public function modify(ProductCollection $collection): void
    {
        $collection->addAttributeToSelect(ProductInterface::NAME);
        $collection->addAttributeToSelect('image');
    }
}

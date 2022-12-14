<?php

namespace Amasty\Checkout\Model\ResourceModel\QuotePasswords;

use Amasty\Checkout\Model\QuotePasswords;
use Amasty\Checkout\Model\ResourceModel\QuotePasswords as ResourceQuotePasswords;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(QuotePasswords::class, ResourceQuotePasswords::class);
    }
}

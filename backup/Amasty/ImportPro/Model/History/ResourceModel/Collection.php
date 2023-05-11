<?php

declare(strict_types=1);

namespace Amasty\ImportPro\Model\History\ResourceModel;

use Amasty\ImportPro\Model\History\History;
use Amasty\ImportPro\Model\History\ResourceModel\History as HistoryResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(History::class, HistoryResource::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }
}

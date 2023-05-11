<?php

declare(strict_types=1);

namespace Amasty\ImportPro\Model\Job\ResourceModel;

use Amasty\ImportPro\Model\Job\Job;
use Amasty\ImportPro\Model\Job\ResourceModel\Job as JobResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Job::class, JobResource::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }
}

<?php

declare(strict_types=1);

namespace Amasty\CronSchedule\Model\Schedule\ResourceModel;

use Amasty\CronSchedule\Model\Schedule\Schedule;
use Amasty\CronSchedule\Model\Schedule\ResourceModel\Schedule as ScheduleResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Schedule::class, ScheduleResource::class);
    }
}

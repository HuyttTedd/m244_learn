<?php

namespace Amasty\CronSchedule\Model\DataProvider;

use Amasty\CronSchedule\Api\Data\ScheduleInterface;
use Magento\Framework\App\RequestInterface;

interface DataProviderInterface
{
    public function getData(string $jobType, int $jobId);

    public function getMeta(string $jobType, array $arguments = []);

    public function prepareSchedule(
        RequestInterface $request,
        string $jobType,
        ?int $jobId
    ): ScheduleInterface;
}

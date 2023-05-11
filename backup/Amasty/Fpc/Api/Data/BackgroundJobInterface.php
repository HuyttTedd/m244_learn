<?php

namespace Amasty\Fpc\Api\Data;

interface BackgroundJobInterface
{
    const JOB_ID = 'job_id';
    const JOB_CODE = 'job_code';

    public function getJobId(): int;

    public function setJobId(int $jobId): BackgroundJobInterface;

    public function getJobCode(): string;

    public function setJobCode(string $jobCode): BackgroundJobInterface;
}

<?php

declare(strict_types=1);

namespace Amasty\Blog\Model\ResourceModel\Posts\Save;

use Amasty\Blog\Model\Posts;

interface SavePartInterface
{
    public function execute(Posts $model): void;
}

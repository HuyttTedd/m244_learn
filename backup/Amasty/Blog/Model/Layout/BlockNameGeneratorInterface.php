<?php

declare(strict_types=1);

namespace Amasty\Blog\Model\Layout;

interface BlockNameGeneratorInterface
{
    public function generate(string $data, string $prefix = ''): string;
}

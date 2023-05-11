<?php

declare(strict_types=1);

namespace Amasty\Blog\Model\Layout;

interface GeneratorInterface
{
    public function generate(Config $layoutConfig): string;
}

<?php

declare(strict_types=1);

namespace Amasty\Blog\Model\Layout;

class LayoutUpdateNameGenerator
{
    const LAYOUT_UPDATE_PREFIX = 'amasty_blog_';

    public function generate(string $identifier): string
    {
        return self::LAYOUT_UPDATE_PREFIX . $identifier;
    }
}

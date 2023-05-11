<?php

declare(strict_types=1);

namespace Amasty\Blog\ViewModel\ContentPreparation\Preparers;

class RemoveScriptsFromContent implements PreparerInterface
{
    public function prepare(string $content): string
    {
        return preg_replace(
            '/<script.+?\/script>/is',
            '',
            $content
        );
    }
}

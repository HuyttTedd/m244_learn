<?php

declare(strict_types=1);

namespace Amasty\Blog\ViewModel\ContentPreparation\Preparers;

class ReplaceVideoToAmpNotation implements PreparerInterface
{
    public function prepare(string $content): string
    {
        return preg_replace(
            '/<video(.+?)\>(.+?)<\/video>/is',
            '<amp-video $1 layout="responsive">$2</amp-video>',
            $content
        );
    }
}

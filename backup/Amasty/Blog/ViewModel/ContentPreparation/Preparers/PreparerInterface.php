<?php

declare(strict_types=1);

namespace Amasty\Blog\ViewModel\ContentPreparation\Preparers;

interface PreparerInterface
{
    public function prepare(string $content): string;
}

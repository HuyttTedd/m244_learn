<?php
declare(strict_types=1);

namespace Amasty\ExportPro\Export\Template\Type\Twig;

interface TwigTemplateInterface
{
    public function getName(): string;

    public function getHeader(): string;

    public function getContent(): string;

    public function getSeparator(): string;

    public function getFooter(): string;

    public function getExtension(): string;
}

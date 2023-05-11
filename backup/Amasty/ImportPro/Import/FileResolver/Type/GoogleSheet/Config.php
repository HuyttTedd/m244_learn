<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\FileResolver\Type\GoogleSheet;

class Config implements ConfigInterface
{
    /**
     * @var string
     */
    private $url;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}

<?php

namespace Amasty\ImportPro\Import\FileResolver\Type\GoogleSheet;

interface ConfigInterface
{
    /**
     * @return string
     */
    public function getUrl(): string;

    /**
     * @param string $url
     *
     * @return void
     */
    public function setUrl(string $url): void;
}

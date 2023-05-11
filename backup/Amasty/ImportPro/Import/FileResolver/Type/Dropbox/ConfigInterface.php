<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\FileResolver\Type\Dropbox;

interface ConfigInterface
{
    /**
     * @return string|null
     */
    public function getToken(): ?string;

    /**
     * @param string $token
     * @return \Amasty\ImportPro\Import\FileResolver\Type\Dropbox\ConfigInterface
     */
    public function setToken(string $token): ConfigInterface;

    /**
     * @return string|null
     */
    public function getFilePath(): ?string;

    /**
     * @param string|null $filePath
     * @return \Amasty\ImportPro\Import\FileResolver\Type\Dropbox\ConfigInterface
     */
    public function setFilePath(?string $filePath): ConfigInterface;
}

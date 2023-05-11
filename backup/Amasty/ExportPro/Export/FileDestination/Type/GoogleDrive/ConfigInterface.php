<?php

namespace Amasty\ExportPro\Export\FileDestination\Type\GoogleDrive;

interface ConfigInterface
{
    /**
     * @return string|null
     */
    public function getKey(): ?string;

    /**
     * @param string $key
     * @return \Amasty\ExportPro\Export\FileDestination\Type\GoogleDrive\ConfigInterface
     */
    public function setKey(string $key): ConfigInterface;

    /**
     * @return string|null
     */
    public function getFilePath(): ?string;

    /**
     * @param string|null $filePath
     * @return \Amasty\ExportPro\Export\FileDestination\Type\GoogleDrive\ConfigInterface
     */
    public function setFilePath(?string $filePath): ConfigInterface;

    /**
     * @return string|null
     */
    public function getFilename(): ?string;

    /**
     * @param string|null $fileName
     * @return \Amasty\ExportPro\Export\FileDestination\Type\GoogleDrive\ConfigInterface
     */
    public function setFilename(?string $fileName): ConfigInterface;
}

<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\FileResolver\Type\GoogleDrive;

use Magento\Framework\DataObject;

class Config extends DataObject implements ConfigInterface
{
    public const KEY = 'key';
    public const FILE_PATH = 'file_path';

    public function getKey(): ?string
    {
        return $this->_getData(self::KEY);
    }

    public function setKey(string $key): ConfigInterface
    {
        return $this->setData(self::KEY, $key);
    }

    public function getFilePath(): ?string
    {
        return $this->_getData(self::FILE_PATH);
    }

    public function setFilePath(?string $filePath): ConfigInterface
    {
        return $this->setData(self::FILE_PATH, $filePath);
    }
}

<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\FileResolver\Type\Dropbox;

use Magento\Framework\DataObject;

class Config extends DataObject implements ConfigInterface
{
    public const TOKEN = 'token';
    public const FILE_PATH = 'file_path';

    public function getToken(): ?string
    {
        return $this->_getData(self::TOKEN);
    }

    public function setToken(string $token): ConfigInterface
    {
        return $this->setData(self::TOKEN, $token);
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

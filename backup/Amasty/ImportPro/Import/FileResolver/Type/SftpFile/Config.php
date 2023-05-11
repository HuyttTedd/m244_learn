<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\FileResolver\Type\SftpFile;

use Magento\Framework\DataObject;

class Config extends DataObject implements ConfigInterface
{
    public const HOST = 'host';
    public const USER = 'user';
    public const PASSWORD = 'password';
    public const PATH = 'path';

    public function getHost(): string
    {
        return $this->getData(self::HOST);
    }

    public function setHost(string $host): void
    {
        $this->setData(self::HOST, $host);
    }

    public function getUser(): string
    {
        return $this->getData(self::USER);
    }

    public function setUser(string $user): void
    {
        $this->setData(self::USER, $user);
    }

    public function getPassword(): string
    {
        return $this->getData(self::PASSWORD);
    }

    public function setPassword(string $password): void
    {
        $this->setData(self::PASSWORD, $password);
    }

    public function getPath(): string
    {
        return $this->getData(self::PATH);
    }

    public function setPath(string $path): void
    {
        $this->setData(self::PATH, $path);
    }
}

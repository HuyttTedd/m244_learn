<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\FileResolver\Type\Rest\Auth\Basic;

class Config implements ConfigInterface
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): ConfigInterface
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): ConfigInterface
    {
        $this->password = $password;

        return $this;
    }
}

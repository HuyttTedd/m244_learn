<?php
declare(strict_types=1);

namespace Amasty\ExportPro\Export\FileDestination\Type\Rest\Auth\Basic;

interface ConfigInterface
{
    /**
     * @return string|null
     */
    public function getUsername(): ?string;

    /**
     * @param string|null $username
     *
     * @return ConfigInterface
     */
    public function setUsername(?string $username): ConfigInterface;

    /**
     * @return string|null
     */
    public function getPassword(): ?string;

    /**
     * @param string|null $password
     *
     * @return ConfigInterface
     */
    public function setPassword(?string $password): ConfigInterface;
}

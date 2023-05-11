<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\FileResolver\Type\Rest\Auth\Bearer;

interface ConfigInterface
{
    /**
     * @return string|null
     */
    public function getToken(): ?string;

    /**
     * @param string|null $token
     *
     * @return ConfigInterface
     */
    public function setToken(?string $token): ConfigInterface;
}

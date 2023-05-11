<?php

namespace Amasty\ImportPro\Import\Source\Type\Xlsx;

interface ConfigInterface
{
    /**
     * @return bool|null
     */
    public function isCombineChildRows(): ?bool;

    /**
     * @param bool|null $combineChildRows
     *
     * @return \Amasty\ImportPro\Import\Source\Type\Xlsx\ConfigInterface
     */
    public function setCombineChildRows(?bool $combineChildRows): ConfigInterface;

    /**
     * @return string|null
     */
    public function getChildRowSeparator(): ?string;

    /**
     * @param string|null $childRowSeparator
     *
     * @return \Amasty\ImportPro\Import\Source\Type\Xlsx\ConfigInterface
     */
    public function setChildRowSeparator(?string $childRowSeparator): ConfigInterface;

    /**
     * @return string|null
     */
    public function getPrefix(): ?string;

    /**
     * @param string|null $prefix
     *
     * @return \Amasty\ImportPro\Import\Source\Type\Xlsx\ConfigInterface
     */
    public function setPrefix(?string $prefix): ConfigInterface;
}

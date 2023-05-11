<?php
declare(strict_types=1);

namespace Amasty\ExportPro\Export\Template\Type\Json;

use Magento\Framework\DataObject;

class Config extends DataObject implements ConfigInterface
{
    const HEADER = 'header';
    const FOOTER = 'footer';

    public function getHeader(): ?string
    {
        return $this->getData(self::HEADER);
    }

    public function setHeader(?string $header): ConfigInterface
    {
        $this->setData(self::HEADER, $header);

        return $this;
    }

    public function getFooter(): ?string
    {
        return $this->getData(self::FOOTER);
    }

    public function setFooter(?string $footer): ConfigInterface
    {
        $this->setData(self::FOOTER, $footer);

        return $this;
    }
}

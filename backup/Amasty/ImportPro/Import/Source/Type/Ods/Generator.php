<?php

declare(strict_types=1);

namespace Amasty\ImportPro\Import\Source\Type\Ods;

use Amasty\ImportCore\Import\Config\ProfileConfig;

class Generator extends \Amasty\ImportPro\Import\Source\Type\Spout\Generator
{
    public function getExtension(): string
    {
        return Reader::TYPE_ID;
    }

    public function getConfig(ProfileConfig $profileConfig)
    {
        return $profileConfig->getExtensionAttributes()->getOdsSource();
    }
}

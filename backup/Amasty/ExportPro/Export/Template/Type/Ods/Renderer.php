<?php

declare(strict_types=1);

namespace Amasty\ExportPro\Export\Template\Type\Ods;

use Amasty\ExportCore\Api\ExportProcessInterface;
use Amasty\ExportCore\Api\Template\RendererInterface;
use Amasty\ExportPro\Export\Template\Type\Spout\Renderer as SpoutRenderer;

class Renderer extends SpoutRenderer implements RendererInterface
{
    const TYPE_ID = 'ods';
    const EXTENSION = 'ods';
    const WRITER_TYPE = \Box\Spout\Common\Type::ODS;

    public function getConfig(ExportProcessInterface $exportProcess)
    {
        return $exportProcess->getProfileConfig()->getExtensionAttributes()->getOdsTemplate();
    }
}

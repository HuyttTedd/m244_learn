<?php

namespace Amasty\Fpc\Model\Source\Provider;

interface SourceProviderInterface
{
    public function getPagesBySourceType(int $sourceType, int $pagesLimit): array;
}

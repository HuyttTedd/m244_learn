<?php

namespace Amasty\Fpc\Model\Source;

interface SourceInterface
{
    /**
     * @param int    $queueLimit
     * @param string $eMessage
     *
     * @return array
     */
    public function getPages($queueLimit, $eMessage);
}

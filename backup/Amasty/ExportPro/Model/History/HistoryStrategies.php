<?php

declare(strict_types=1);

namespace Amasty\ExportPro\Model\History;

class HistoryStrategies
{
    private $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

    public function isLogStrategy(string $strategy): bool
    {
        return in_array($strategy, $this->strategies);
    }
}

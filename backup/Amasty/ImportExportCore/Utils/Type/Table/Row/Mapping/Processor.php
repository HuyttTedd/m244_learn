<?php
declare(strict_types=1);

namespace Amasty\ImportExportCore\Utils\Type\Table\Row\Mapping;

class Processor
{
    public function process(array $data, array $map): array
    {
        $result = [];
        foreach ($data as $row) {
            $outputRow = [];
            foreach ($map['fields'] as $field => $alias) {
                $outputRow[!empty($alias) ? $alias : $field] = $row[$field] ?? '';
            }
            if (!empty($map['subentities'])) {
                foreach ($map['subentities'] as $field => $subentity) {
                    $outputRow[!empty($subentity['map']) ? $subentity['map'] : $field] = $this->process(
                        $row[$field] ?? [],
                        $subentity
                    );
                }
            }
            $result[] = $outputRow;
        }

        return $result;
    }
}

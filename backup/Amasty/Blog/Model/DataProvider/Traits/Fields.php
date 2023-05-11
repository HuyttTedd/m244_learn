<?php

namespace Amasty\Blog\Model\DataProvider\Traits;

use Amasty\Blog\Api\Data\PostInterface;

trait Fields
{
    public function getFieldsByStore(): \Generator
    {
        foreach (PostInterface::FIELDS_BY_STORE as $field) {
            if (isset($field['children'])) {
                foreach ($field['children'] as $childName => $child) {
                    yield $field['children'][$childName] ?? [];
                }
            }
        }
    }
}

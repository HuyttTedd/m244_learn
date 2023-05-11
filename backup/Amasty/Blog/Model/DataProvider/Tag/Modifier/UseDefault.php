<?php

namespace Amasty\Blog\Model\DataProvider\Tag\Modifier;

use Amasty\Blog\Api\Data\TagInterface;
use Amasty\Blog\Model\DataProvider\AbstractModifier;

class UseDefault extends AbstractModifier
{
    /**
     * @return array
     */
    public function getFieldsByStore()
    {
        return TagInterface::FIELDS_BY_STORE;
    }
}

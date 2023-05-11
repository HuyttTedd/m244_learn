<?php

namespace Amasty\Blog\Model\DataProvider\Category\Modifier;

use Amasty\Blog\Api\Data\CategoryInterface;
use Amasty\Blog\Model\DataProvider\AbstractModifier;

class UseDefault extends AbstractModifier
{
    /**
     * @return array
     */
    public function getFieldsByStore()
    {
        return CategoryInterface::FIELDS_BY_STORE;
    }
}

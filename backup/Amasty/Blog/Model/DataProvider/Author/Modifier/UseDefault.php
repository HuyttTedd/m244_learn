<?php

namespace Amasty\Blog\Model\DataProvider\Author\Modifier;

use Amasty\Blog\Api\Data\AuthorInterface;
use Amasty\Blog\Model\DataProvider\AbstractModifier;

class UseDefault extends AbstractModifier
{
    /**
     * @return array
     */
    public function getFieldsByStore()
    {
        return AuthorInterface::FIELDS_BY_STORE;
    }
}

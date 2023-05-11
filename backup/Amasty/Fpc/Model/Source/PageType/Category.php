<?php

namespace Amasty\Fpc\Model\Source\PageType;

use Magento\UrlRewrite\Controller\Adminhtml\Url\Rewrite as UrlRewrite;

class Category extends Rewrite
{
    /**
     * @var string
     */
    protected $rewriteType = UrlRewrite::ENTITY_TYPE_CATEGORY;
}

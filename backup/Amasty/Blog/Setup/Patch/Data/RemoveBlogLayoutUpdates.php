<?php

declare(strict_types=1);

namespace Amasty\Blog\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;

class RemoveBlogLayoutUpdates implements DataPatchInterface
{
    /**
     * @var ApplyBlogLayoutConfig
     */
    private $applyBlogLayoutConfig;

    public function __construct(
        ApplyBlogLayoutConfig $applyBlogLayoutConfig
    ) {
        $this->applyBlogLayoutConfig = $applyBlogLayoutConfig;
    }

    public static function getDependencies(): array
    {
        return [
            ApplyBlogLayoutConfig::class
        ];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply(): RemoveBlogLayoutUpdates
    {
        $this->applyBlogLayoutConfig->revert();

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Amasty\Blog\Model\Config;

use Magento\Framework\Data\OptionSourceInterface;

class GdprBlog implements OptionSourceInterface
{
    const GDPR_BLOG_COMMENT_FORM = 'amblog_comment_form';

    /**
     * @return array|array[]
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => [
                    ['value' => self::GDPR_BLOG_COMMENT_FORM, 'label' => __('Comment Form')]
                ],
                'label' => __('Blog Pro')
            ]
        ];
    }
}

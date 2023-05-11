<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\Source\Type\Spout;

use Amasty\ImportCore\Api\FormInterface;

abstract class AbstractMeta implements FormInterface
{
    public const FORMAT = '';

    public function isLibExists(): bool
    {
        try {
            $classExists = class_exists(\Box\Spout\Common\Type::class);
        } catch (\Exception $e) {
            $classExists = false;
        }

        return $classExists;
    }

    protected function getNoticeMeta(): array
    {
        return [
            'comment' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => '',
                            'formElement' => 'container',
                            'componentType' => 'container',
                            'template' => 'Amasty_ImportPro/notice-field',
                            'additionalClasses' => 'admin__fieldset-note',
                            'visible' => true,
                            'content' => __(
                                'PHP library <a href="https://github.com/box/spout" target="_blank">Spout</a> is not '
                                . 'installed. Please install the library to proceed with %1 format.',
                                static::FORMAT
                            )
                        ],
                    ],
                ]
            ]
        ];
    }
}

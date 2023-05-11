<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\Source\Type\Ods;

use Amasty\ImportCore\Api\Config\EntityConfigInterface;
use Amasty\ImportCore\Api\Config\ProfileConfigInterface;
use Amasty\ImportCore\Api\FormInterface;
use Amasty\ImportPro\Import\Source\Type\Spout\AbstractMeta;
use Magento\Framework\App\RequestInterface;

class Meta extends AbstractMeta
{
    public const DATASCOPE = 'extension_attributes.ods_source.';
    public const FORMAT = 'ODS';

    /**
     * @var ConfigFactory
     */
    private $configFactory;

    public function __construct(
        ConfigInterfaceFactory $configFactory
    ) {
        $this->configFactory = $configFactory;
    }

    public function getMeta(EntityConfigInterface $entityConfig, array $arguments = []): array
    {
        if (!$this->isLibExists()) {
            return $this->getNoticeMeta();
        }

        $result = [
            'ods.combine_child_rows' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Rows Merged into One'),
                            'dataType' => 'boolean',
                            'prefer' => 'toggle',
                            'dataScope' => self::DATASCOPE . 'combine_child_rows',
                            'valueMap' => ['true' => '1', 'false' => '0'],
                            'default' => '',
                            'formElement' => 'checkbox',
                            'visible' => true,
                            'sortOrder' => 20,
                            'componentType' => 'field',
                            'notice' => __(
                                'Please enable the setting if you have data from multiple rows merged into one cell.'
                            ),
                            'switcherConfig' => [
                                'enabled' => true,
                                'rules'   => [
                                    [
                                        'value'   => 0,
                                        'actions' => [
                                            [
                                                'target'   => 'index = ods.child_rows.delimiter',
                                                'callback' => 'visible',
                                                'params'   => [false]
                                            ]
                                        ]
                                    ],
                                    [
                                        'value'   => 1,
                                        'actions' => [
                                            [
                                                'target'   => 'index = ods.child_rows.delimiter',
                                                'callback' => 'visible',
                                                'params'   => [true]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'ods.child_rows.delimiter' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Merged Rows Data Delimiter'),
                            'dataType' => 'text',
                            'default' => Config::SETTING_CHILD_ROW_SEPARATOR,
                            'formElement' => 'input',
                            'visible' => true,
                            'sortOrder' => 30,
                            'componentType' => 'field',
                            'dataScope' => self::DATASCOPE . 'child_row_separator',
                            'validation' => [
                                'required-entry' => true
                            ],
                            'notice' => __('The character that delimits each field of the child rows.')
                        ]
                    ]
                ]
            ],
            'ods.postfix' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Prefix/Tag Delimiter'),
                            'dataType' => 'text',
                            'default' => Config::SETTING_PREFIX,
                            'visible' => true,
                            'sortOrder' => 40,
                            'formElement' => 'input',
                            'componentType' => 'field',
                            'dataScope' => self::DATASCOPE . 'postfix',
                            'notice' => __('The character that separates the prefix/tag from the column name.')
                        ]
                    ]
                ]
            ]
        ];

        return $result;
    }

    public function prepareConfig(ProfileConfigInterface $profileConfig, RequestInterface $request): FormInterface
    {
        $config = $this->configFactory->create();
        $requestConfig = $request->getParam('extension_attributes')['ods_source'] ?? [];

        if (isset($requestConfig['combine_child_rows'])) {
            $config->setCombineChildRows((bool)$requestConfig['combine_child_rows']);
            $config->setChildRowSeparator((string)$requestConfig['child_row_separator']);
        }
        if (isset($requestConfig['postfix'])) {
            $config->setPrefix((string)$requestConfig['postfix']);
        }
        $profileConfig->getExtensionAttributes()->setOdsSource($config);

        return $this;
    }

    public function getData(ProfileConfigInterface $profileConfig): array
    {
        if ($config = $profileConfig->getExtensionAttributes()->getOdsSource()) {
            return [
                'extension_attributes' => [
                    'ods_source' => [
                        'prefix' => $config->getPrefix(),
                        'combine_child_rows' => $config->isCombineChildRows() ? '1' : '0',
                        'child_row_separator' => $config->getChildRowSeparator(),
                    ]
                ]
            ];
        }

        return [];
    }
}

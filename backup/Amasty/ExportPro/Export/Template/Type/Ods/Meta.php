<?php

declare(strict_types=1);

namespace Amasty\ExportPro\Export\Template\Type\Ods;

use Amasty\ExportCore\Api\Config\EntityConfigInterface;
use Amasty\ExportCore\Api\Config\ProfileConfigInterface;
use Amasty\ExportCore\Api\FormInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Asset\Repository;

class Meta extends \Amasty\ExportPro\Export\Template\Type\Spout\Meta implements FormInterface
{
    const FORMAT = 'ODS';
    const DATASCOPE = 'extension_attributes.ods_template.';

    /**
     * @var ConfigInterfaceFactory
     */
    private $configFactory;

    /**
     * @var Repository
     */
    private $assetRepo;

    public function __construct(
        ConfigInterfaceFactory $configInterfaceFactory,
        Repository $assetRepo
    ) {
        $this->configFactory = $configInterfaceFactory;
        $this->assetRepo = $assetRepo;
    }

    public function getMeta(EntityConfigInterface $entityConfig, array $arguments = []): array
    {
        if (!$this->isLibExists()) {
            return $this->getNoticeMeta();
        }

        if (!empty($arguments['combineChildRowsImage'])) {
            $combineChildRowsImage = $this->assetRepo->getUrl($arguments['combineChildRowsImage']);
        } else {
            $combineChildRowsImage = $this->assetRepo->getUrl('Amasty_ExportCore::images/merge_rows.gif');
        }

        return [
            'ods.has_header_row' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Add Header Row'),
                            'dataType' => 'boolean',
                            'prefer' => 'toggle',
                            'dataScope' => self::DATASCOPE . 'has_header_row',
                            'valueMap' => ['true' => '1', 'false' => '0'],
                            'default' => '1',
                            'formElement' => 'checkbox',
                            'visible' => true,
                            'componentType' => 'field'
                        ]
                    ]
                ]
            ],
            'ods.combine_child_rows' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Merge Rows into One'),
                            'dataType' => 'boolean',
                            'prefer' => 'toggle',
                            'additionalClasses' => 'amexportcore-checkbox -type',
                            'dataScope' => self::DATASCOPE . 'combine_child_rows',
                            'valueMap' => ['true' => '1', 'false' => '0'],
                            'default' => '',
                            'formElement' => 'checkbox',
                            'visible' => true,
                            'componentType' => 'field',
                            'tooltipTpl' => 'Amasty_ExportCore/form/element/tooltip',
                            'tooltip' => [
                                'description' => '<img src="' . $combineChildRowsImage . '"/>'
                            ],
                            'notice' => __('Data from multiple rows will be merged into one cell, if enabled.'),
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
                                            ],
                                            [
                                                'target'   => 'index = ods.duplicate_parent_data',
                                                'callback' => 'visible',
                                                'params'   => [true]
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
                                            ],
                                            [
                                                'target'   => 'index = ods.duplicate_parent_data',
                                                'callback' => 'visible',
                                                'params'   => [false]
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
            'ods.duplicate_parent_data' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Duplicate Parent Entity Data'),
                            'dataType' => 'boolean',
                            'prefer' => 'toggle',
                            'additionalClasses' => 'amexportcore-checkbox -type',
                            'dataScope' => self::DATASCOPE . 'duplicate_parent_data',
                            'valueMap' => ['true' => '1', 'false' => '0'],
                            'default' => '',
                            'formElement' => 'checkbox',
                            'visible' => true,
                            'componentType' => 'field',
                            'notice' => __(
                                'Please use the setting while exporting one sequence of subentity, e.g. Order - '
                                . 'Order Item - Product - Product Attribute, to avoid duplicating independent data.'
                            ),
                            'tooltipTpl' => 'Amasty_ExportCore/form/element/tooltip',
                            'tooltip' => [
                                'description' => __(
                                    'If enabled, parent entity data will be duplicated in each '
                                    . 'row when exporting the second and subsequent rows of child entity data.'
                                )
                            ]
                        ]
                    ]
                ]
            ],
            'ods.postfix' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Entity Key Delimiter'),
                            'dataType' => 'text',
                            'default' => Config::SETTING_POSTFIX,
                            'visible' => true,
                            'formElement' => 'input',
                            'componentType' => 'field',
                            'dataScope' => self::DATASCOPE . 'postfix',
                            'notice' => __('The character that separates the entity key from the column name.')
                        ]
                    ]
                ]
            ]
        ];
    }

    public function prepareConfig(ProfileConfigInterface $profileConfig, RequestInterface $request): FormInterface
    {
        $config = $this->configFactory->create();
        $requestConfig = $request->getParam('extension_attributes')['ods_template'] ?? [];

        if (isset($requestConfig['has_header_row'])) {
            $config->setHasHeaderRow((bool)$requestConfig['has_header_row']);
        }
        if (isset($requestConfig['postfix'])) {
            $config->setPostfix((string)$requestConfig['postfix']);
        }
        if (isset($requestConfig['combine_child_rows'])) {
            $config->setCombineChildRows((bool)$requestConfig['combine_child_rows']);
            $config->setChildRowSeparator((string)$requestConfig['child_row_separator']);
        }
        if (isset($requestConfig['duplicate_parent_data'])) {
            $config->setDuplicateParentData((bool)$requestConfig['duplicate_parent_data']);
        }

        $profileConfig->getExtensionAttributes()->setOdsTemplate($config);

        return $this;
    }

    public function getData(ProfileConfigInterface $profileConfig): array
    {
        if ($config = $profileConfig->getExtensionAttributes()->getOdsTemplate()) {
            return [
                'extension_attributes' => [
                    'ods_template' => [
                        'has_header_row' => $config->isHasHeaderRow() ? '1' : '0',
                        'postfix' => $config->getPostfix(),
                        'combine_child_rows' => $config->isCombineChildRows() ? '1' : '0',
                        'child_row_separator' => $config->getChildRowSeparator(),
                        'duplicate_parent_data' => $config->isDuplicateParentData() ? '1' : '0'
                    ]
                ]
            ];
        }

        return [];
    }
}

<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\Form;

use Amasty\ImportCore\Api\Config\EntityConfigInterface;
use Amasty\ImportCore\Api\Config\ProfileConfigInterface;
use Amasty\ImportCore\Api\FormInterface;
use Magento\Framework\App\RequestInterface;

class Fields extends \Amasty\ImportCore\Import\Form\FieldsAdvanced
{
    /**
     * @var string
     */
    private $customPrefixTagNameImage;

    public function getData(ProfileConfigInterface $profileConfig): array
    {
        $data = parent::getData($profileConfig);
        $data['fields'][$profileConfig->getEntityCode()]['use_custom_prefix'] =
            $profileConfig->getExtensionAttributes()->getUseCustomPrefix();

        return $data;
    }

    public function prepareConfig(ProfileConfigInterface $profileConfig, RequestInterface $request): FormInterface
    {
        parent::prepareConfig($profileConfig, $request);
        $profileConfig->getExtensionAttributes()->setUseCustomPrefix(
            $request->getParam('fields')['customer_entity']['use_custom_prefix'] ?? '0'
        );

        return $this;
    }

    public function prepareFieldsContainers(
        EntityConfigInterface $entityConfig,
        ?array $relationsConfig,
        int $level,
        string $fieldName = '',
        string $parentKey = ''
    ): array {
        $result = parent::prepareFieldsContainers($entityConfig, $relationsConfig, $level, $fieldName, $parentKey);
        $index = $this->getEntityIndex($parentKey, $entityConfig->getEntityCode());
        if ($level === 0) {
            $result[$index]['children']['use_custom_prefix'] = [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Use Custom Entity Key'),
                            'dataType' => 'boolean',
                            'prefer' => 'toggle',
                            'valueMap' => ['true' => '1', 'false' => '0'],
                            'default' => '',
                            'sortOrder' => '0',
                            'formElement' => 'checkbox',
                            'visible' => true,
                            'componentType' => 'field',
                            'tooltipTpl' => 'Amasty_ImportCore/form/element/tooltip',
                            'tooltip' => [
                                'description' => '<img src="' . $this->getCustomPrefixTagNameImage(). '"/>'
                            ]
                        ]
                    ]
                ]
            ];
        } elseif (isset($result[$index]['children'][$index . '_container']['children']['field_code'])) {
            $result[$index]['children'][$index . '_container']['children']['field_code']['arguments']['data']
            ['config']['formElement'] = 'hidden';
        }

        return $result;
    }

    protected function getCustomPrefixTagNameImage(): string
    {
        if (null === $this->customPrefixTagNameImage) {
            if (!empty($this->arguments['customPrefixTagNameImage'])) {
                $this->customPrefixTagNameImage = $this->assetRepo->getUrl(
                    $this->arguments['customPrefixTagNameImage']
                );
            } else {
                $this->customPrefixTagNameImage = $this->assetRepo->getUrl(
                    'Amasty_ImportCore::images/custom_prefix_tag_name.gif'
                );
            }
        }

        return $this->customPrefixTagNameImage;
    }
}

<?php
declare(strict_types=1);

namespace Amasty\OrderImport\Import\Form;

use Amasty\ImportCore\Api\Config\EntityConfigInterface;
use Amasty\ImportCore\Api\Config\ProfileConfigInterface;
use Amasty\ImportCore\Api\FormInterface;
use Amasty\ImportCore\Import\Form\CompositeForm;
use Amasty\ImportCore\Import\Utils\Hash;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Asset\Repository;

class Fields extends CompositeForm implements FormInterface
{
    /**
     * @var Repository
     */
    private $assetRepo;

    /**
     * @var Hash
     */
    private $hash;

    public function __construct(
        Repository $assetRepo,
        Hash $hash,
        array $metaProviders
    ) {
        parent::__construct($metaProviders);
        $this->assetRepo = $assetRepo;
        $this->hash = $hash;
    }

    public function getMeta(EntityConfigInterface $entityConfig, array $arguments = []): array
    {
        $result = ['fields' => ['children' => []]];
        foreach ($this->getFormGroupProviders() as $formGroup) {
            $result['fields']['children'] = array_merge_recursive(
                $result['fields']['children'],
                $formGroup['metaClass']->getMeta($entityConfig, $formGroup['arguments'] ?? [])
            );
        }
        $this->modifyMeta($result);

        return $result;
    }

    public function getData(ProfileConfigInterface $profileConfig): array
    {
        $result = [];
        foreach ($this->getFormGroupProviders() as $formGroup) {
            $result = array_merge_recursive($result, $formGroup['metaClass']->getData($profileConfig));
        }
        if (empty($result)) {
            return [];
        }

        $result['fields']['sales_order']['use_custom_prefix'] = $profileConfig
            ->getExtensionAttributes()->getUseCustomPrefix();
        $result['fields']['sales_order']['field_postfix'] = $profileConfig
            ->getExtensionAttributes()->getFieldPostfix();

        return ['fields' => $result];
    }

    public function prepareConfig(ProfileConfigInterface $profileConfig, RequestInterface $request): FormInterface
    {
        $params = $request->getParams();
        $fields = $params['fields'] ?? [];
        unset($params['fields']);
        $params = array_merge_recursive($params, $fields);
        $request->setParams($params);
        foreach ($this->getFormGroupProviders() as $formGroup) {
            $formGroup['metaClass']->prepareConfig($profileConfig, $request);
        }

        $profileConfig->getExtensionAttributes()->setUseCustomPrefix(
            $params['fields']['sales_order']['use_custom_prefix'] ?? '0'
        );

        return $this;
    }

    protected function modifyMeta(array &$meta): void
    {
        $fieldPostfixMeta = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Entity Key Delimiter'),
                        'dataType' => 'text',
                        'default' => '.',
                        'visible' => true,
                        'formElement' => 'input',
                        'componentType' => 'field',
                        'sortOrder' => '5',
                        'tooltipTpl' => 'Amasty_ImportCore/form/element/tooltip',
                        'tooltip' => [
                            'description' => '<img src="'
                                . $this->assetRepo->getUrl(
                                    'Amasty_ImportCore::images/custom_prefix_tag_name.gif'
                                )
                                . '"/>'
                        ]
                    ]
                ]
            ]
        ];
        $meta['fields']['children']['fieldsConfigAdvanced']['children']
        [$this->hash->hash('sales_order')]['children']['field_postfix'] = $fieldPostfixMeta;
        $meta['fields']['children']['fieldsConfigAdvanced']['children']
        [$this->hash->hash('sales_order')]['children']
        ['addField']['arguments']['data']['config']['sortOrder'] = 10;

        $customerEntityConfig = &$meta['fields']['children']['fieldsConfigAdvanced']
        ['children'][$this->hash->hash('sales_order')]['arguments']['data']['config'];
        $customerEntityConfig['label'] = __('Order (root entity)');
        $customerEntityConfig['additionalClasses'] = 'amorderimport-fieldset-withtooltip';
        $customerEntityConfig['template'] = 'Amasty_OrderImport/form/fieldset';
        $customerEntityConfig['tooltipTpl'] = 'Amasty_ImportCore/form/element/tooltip';
        $customerEntityConfig['tooltip'] = [
            'description' => '<img src="'
                . $this->assetRepo->getUrl(
                    'Amasty_OrderImport::images/order_root_entity.gif'
                )
                . '"/>'
        ];
    }
}

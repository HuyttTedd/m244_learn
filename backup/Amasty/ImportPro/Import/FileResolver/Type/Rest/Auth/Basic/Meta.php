<?php
declare(strict_types=1);

namespace Amasty\ImportPro\Import\FileResolver\Type\Rest\Auth\Basic;

use Amasty\ImportCore\Api\Config\EntityConfigInterface;
use Amasty\ImportCore\Api\Config\ProfileConfigInterface;
use Amasty\ImportCore\Api\FormInterface;
use Magento\Framework\App\RequestInterface;

class Meta implements \Amasty\ImportCore\Api\FormInterface
{
    public const CODE = 'basic';
    public const DATASCOPE = 'auth-basic.';

    /**
     * @var ConfigInterfaceFactory
     */
    private $configFactory;

    public function __construct(ConfigInterfaceFactory $configFactory)
    {
        $this->configFactory = $configFactory;
    }

    public function getMeta(EntityConfigInterface $entityConfig, array $arguments = []): array
    {
        return [
            'basic_username' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Username'),
                            'validation' => [
                                'required-entry' => true
                            ],
                            'dataType' => 'text',
                            'formElement' => 'input',
                            'visible' => true,
                            'componentType' => 'input',
                            'dataScope' => self::DATASCOPE . 'username'
                        ]
                    ]
                ]
            ],
            'rest_file.basic_password' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Password'),
                            'validation' => [
                                'required-entry' => true
                            ],
                            'dataType' => 'text',
                            'formElement' => 'input',
                            'elementTmpl' => 'Amasty_ImportPro/form/element/password',
                            'visible' => true,
                            'componentType' => 'input',
                            'dataScope' => self::DATASCOPE . 'password'
                        ]
                    ]
                ]
            ]
        ];
    }

    public function getData(ProfileConfigInterface $profileConfig): array
    {
        /** @var ConfigInterface $config */
        $config = $profileConfig->getExtensionAttributes()->getRestFileResolver()
            ->getExtensionAttributes()->getBasic();
        if ($config) {
            return [
                'auth-basic' => [
                    'username' => $config->getUsername(),
                    'password' => $config->getPassword()
                ]
            ];
        }

        return [];
    }

    public function prepareConfig(ProfileConfigInterface $profileConfig, RequestInterface $request): FormInterface
    {
        /** @var ConfigInterface $config */
        $config = $this->configFactory->create();
        /** @var ProfileConfigInterface $profileConfig */
        $requestConfig = $request->getParam('auth-basic') ?? [];
        if (isset($requestConfig['username'])) {
            $config->setUsername($requestConfig['username']);
        }
        if (isset($requestConfig['password'])) {
            $config->setPassword($requestConfig['password']);
        }

        $profileConfig->getExtensionAttributes()->getRestFileResolver()
            ->getExtensionAttributes()->setBasic($config);

        return $this;
    }
}

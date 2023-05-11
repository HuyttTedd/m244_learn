<?php

namespace Amasty\Fpc\Model\ResourceModel;


class FieldDataConverterFactory
{
    /**
     * Object manager
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function create()
    {
        return $this->objectManager->create(
            'Magento\Framework\DB\AggregatedFieldDataConverter'
        );
    }
}
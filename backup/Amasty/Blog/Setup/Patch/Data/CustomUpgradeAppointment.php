<?php

declare(strict_types=1);

namespace Amasty\Blog\Setup\Patch\Data;

use Magento\Catalog\Model\ProductFactory;
use Magento\Eav\Model\Entity\Attribute\Set;
use Magento\Eav\Model\Entity\Type;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Store\Model\ResourceModel\Store\Collection;
use Magento\Store\Model\ResourceModel\Store\CollectionFactory as StoreCollectionFactory;
use Magento\Catalog\Model\ProductRepository;

class CustomUpgradeAppointment implements DataPatchInterface
{
    /**
     * @var State
     */
    private $appState;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var StoreCollectionFactory
     */
    private $storeCollectionFactory;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @var Set
     */
    private $entityAttrSet;

    /**
     * @var Type
     */
    private $entityType;

    /**
     * Data constructor.
     *
     * @param State $appState
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param ProductFactory $productFactory
     * @param Set $entityAttrSet
     * @param Type $entityType
     * @param StoreCollectionFactory $storeCollectionFactory
     * @param ProductRepository $productRepository
     */
    public function __construct(
        State $appState,
        ModuleDataSetupInterface $moduleDataSetup,
        ProductFactory $productFactory,
        Set $entityAttrSet,
        Type $entityType,
        StoreCollectionFactory $storeCollectionFactory,
        ProductRepository $productRepository
    ) {
        $this->appState = $appState;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->entityAttrSet = $entityAttrSet;
        $this->entityType = $entityType;
        $this->productFactory = $productFactory;
        $this->storeCollectionFactory = $storeCollectionFactory;
        $this->productRepository = $productRepository;
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply(): self
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/logg.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('fffaaaaaaaaa');
        $this->appState->emulateAreaCode(
            Area::AREA_ADMINHTML,
            [$this, 'migrationPostToScope']
        );

        return $this;
    }

    public function migrationPostToScope(): void
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/logg.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('fff');
        /** @var Collection $storeCollection */
        $product = $this->productFactory->create();
        $product->setUrlKey(uniqid("custom_upgrade_service"));
        $product->setName('Custom Upgrade Service 2');
        $product->setTypeId('virtual');
        $product->setStatus(1);
        $product->setAttributeSetId($this->getAttributeSetForCustomSalesProduct());
        $product->setSku("TEST-112");
        $product->setVisibility(4);
        $product->setPrice(0);
//        $this->productRepository->save($product);
    }

    /**
     * PERFECT CODE
     *
     * @return int
     */
    public function getAttributeSetForCustomSalesProduct() {
        $productEntityTypeId       = $this->entityType->loadByCode('catalog_product')->getId();
        $eavAttributeSetCollection = $this->entityAttrSet->getCollection();

        // FIXME: We will implement setting for admin select attribute set of customer later.
        $eavAttributeSetCollection->addFieldToFilter('attribute_set_name', 'Default')->addFieldToFilter('entity_type_id', $productEntityTypeId);

        $id = $eavAttributeSetCollection->getFirstItem()->getId();

        if (is_null($id)) {
            $eavAttributeSetCollection = $this->entityAttrSet->getCollection();

            return $eavAttributeSetCollection->addFieldToFilter('entity_type_id', $productEntityTypeId)->getFirstItem()->getId();
        }

        return $id;
    }
}

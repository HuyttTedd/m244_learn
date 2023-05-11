<?php

declare(strict_types=1);

namespace Smartosc\RedirectStore\Model\Source;

use Magento\Config\Model\Config\Source\Website as CoreSourceWebsite;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\System\Store as StoreSystem;

class Website extends CoreSourceWebsite
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var StoreSystem
     */
    protected $systemStore;

    /**
     * @param StoreManagerInterface $storeManager
     * @param StoreSystem $systemStore
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        StoreSystem $systemStore
    ) {
        parent::__construct($storeManager);
        $this->systemStore = $systemStore;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $data = parent::toOptionArray();
        $arrMapping = [];
        foreach ($data as $key => $item) {
            if (isset($item['value']) && isset($item['label'])) {
                $arrMapping[] = ['label' => $item['label'], 'value' => $item['value']];
            }
        }

        return $arrMapping;
    }
}

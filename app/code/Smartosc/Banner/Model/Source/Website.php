<?php

declare(strict_types=1);

namespace Smartosc\Banner\Model\Source;

use Magento\Config\Model\Config\Source\Website as CoreSourceWebsite;

class Website extends CoreSourceWebsite
{
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
            if (isset($item['label'])) {
                $arrMapping[$item['value']] = $item['label'];
            }
        }

        return $arrMapping;
    }
}

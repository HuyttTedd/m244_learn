<?php
declare(strict_types=1);

namespace Amasty\OrderImport\Block\Adminhtml\Edit\Button;

use Amasty\ImportCore\Block\Adminhtml\Import\DownloadSampleFile as CoreDownloadSampleFile;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DownloadSampleFile extends CoreDownloadSampleFile implements ButtonProviderInterface
{
    /**
     * @var GenericButton
     */
    private $genericButton;

    public function __construct(
        Context $context,
        GenericButton $genericButton
    ) {
        parent::__construct($context);
        $this->genericButton = $genericButton;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        if ($this->genericButton->isDuplicate()) {
            return [];
        }

        $data = parent::getButtonData();
        $data['data_attribute']['mage-init']['Magento_Ui/js/form/button-adapter']['actions'][0]['targetName']
            = 'order_import_profile_form.areas';
        $data['sort_order'] = 10;

        return $data;
    }
}

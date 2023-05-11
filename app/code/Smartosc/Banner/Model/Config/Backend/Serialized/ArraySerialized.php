<?php

declare(strict_types=1);

namespace Smartosc\Banner\Model\Config\Backend\Serialized;

use Magento\Config\Model\Config\Backend\Serialized;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Amasty\Base\Model\Serializer;
use Smartosc\Banner\Model\Configuration;

/**
 * class ArraySerialized.
 */
class ArraySerialized extends Serialized
{
    const UPLOAD_DIR    = 'pub/media/smartosc/banner';
    const MAX_FILE_SIZE = 10240000;
    /**
     * @var UploaderFactory
     */
    protected $_uploaderFactory;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Serializer
     */
    protected $serialize;

    /**
     * Serialized constructor
     *
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param UploaderFactory $uploaderFactory
     * @param Configuration $configuration
     * @param Serializer $serialize
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     * @param Json|null $serializer
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        UploaderFactory $uploaderFactory,
        Configuration $configuration,
        Serializer $serialize,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        Json $serializer = null
    ) {
        $this->_uploaderFactory = $uploaderFactory;
        $this->configuration = $configuration;
        $this->serialize = $serialize;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data, $serializer);
    }

    /**
     * Unset array element with '__empty' key
     *
     * @return $this
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        $row = [];
        $data = [];
        if (is_array($value)) {
            unset($value['__empty']);
            $value = $this->sortingData($value);
            foreach ($value as $key => $val) {
                if (isset($val['banner_file']) || !isset($val['website_ids'])) {
                    break;
                }

                $row['website_ids'] = $val['website_ids'] ?? '';
                $bannerIndex = (count($value) / 2) + $key;
                if (isset($value[$bannerIndex]['banner_file']['name']) && isset($value[$key]['banner_file_name']) && !$value[$bannerIndex]['banner_file']['name']) {
                    $row['banner_file'] = $value[$key]['banner_file_name'];
                } elseif (isset($value[$bannerIndex]['banner_file']['name']) && $value[$bannerIndex]['banner_file']['name']) {
                    $row['banner_file'] = $this->handleImg($value[$bannerIndex]['banner_file']);
                } else {
                    throw new LocalizedException(__('Something went wrong!'));
                }
                $data[] = $row;
            }
        }

        $this->setValue($data);
        return parent::beforeSave();
    }

    /**
     * @param array $file
     * @return string
     */
    public function handleImg(array $file): string
    {
        try {
            $uploader = $this->_uploaderFactory->create(['fileId' => $file]);
            $uploader->setAllowedExtensions($this->_getAllowedExtensions());
            $uploader->setAllowRenameFiles(true);
            $this->validateMaxSize($file['size'] ?? 0);
            $result = $uploader->save(self::UPLOAD_DIR);
        } catch (\Exception $e) {
            throw new LocalizedException(__('%1', $e->getMessage()));
        }

        return $result['file'] ?? '';
    }

    /**
     * Getter for allowed extensions of uploaded files
     *
     * @return string[]
     */
    protected function _getAllowedExtensions(): array
    {
        return ['jpg', 'jpeg', 'gif', 'png'];
    }

    /**
     *
     * @param array $data
     * @return array
     */
    protected function sortingData(array $data): array
    {
        $newData = [];
        $count = 0;
        foreach ($data as $key => $item) {
            if ($item) {
                $newData[$count] = $item;
                $count++;
            }
        }
        return $newData;
    }

    /**
     * Validation for checking max file size
     *
     * @param int $filesize
     * @return void
     * @throws LocalizedException
     */
    public function validateMaxSize(int $filesize)
    {
        if ($filesize > self::MAX_FILE_SIZE) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('The file you\'re uploading exceeds the server size limit of %1 Megabytes.', self::MAX_FILE_SIZE)
            );
        }
    }
}

<?php

declare(strict_types=1);

namespace Amasty\OrderImport\Model\Profile;

use Amasty\CronSchedule\Api\Data\ScheduleInterface;
use Amasty\ImportCore\Api\Config\ProfileConfigInterface;
use Amasty\OrderImport\Api\Data\ProfileInterface;
use Magento\Framework\Model\AbstractModel;

class Profile extends AbstractModel implements ProfileInterface
{
    public const ID = 'id';
    public const NAME = 'name';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const IMPORTED_AT = 'imported_at';
    public const SERIALIZED_CONFIG = 'serialized_config';
    public const CONFIG = 'config';
    public const SOURCE_TYPE = 'source_type';
    public const EXECUTION_TYPE = 'execution_type';
    public const SCHEDULE = 'schedule';
    public const ORDER_ACTIONS = 'order_actions';
    public const PROFILE_EVENT = 'profile_event';

    public function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel\Profile::class);
        $this->setIdFieldName(self::ID);
    }

    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    public function setName(?string $name): ProfileInterface
    {
        $this->setData(self::NAME, $name);

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(?string $createdAt): ProfileInterface
    {
        $this->setData(self::CREATED_AT, $createdAt);

        return $this;
    }

    public function getImportedAt(): ?string
    {
        return $this->getData(self::IMPORTED_AT);
    }

    public function setImportedAt(?string $importedAt): ProfileInterface
    {
        $this->setData(self::IMPORTED_AT, $importedAt);

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt(?string $updatedAt): ProfileInterface
    {
        $this->setData(self::UPDATED_AT, $updatedAt);

        return $this;
    }

    public function getSerializedConfig(): ?string
    {
        return $this->getData(self::SERIALIZED_CONFIG);
    }

    public function setSerializedConfig(?string $serializedConfig): ProfileInterface
    {
        $this->setData(self::SERIALIZED_CONFIG, $serializedConfig);

        return $this;
    }

    public function getConfig(): ?ProfileConfigInterface
    {
        return $this->getData(self::CONFIG);
    }

    public function setConfig(?ProfileConfigInterface $config): ProfileInterface
    {
        $this->setData(self::CONFIG, $config);

        return $this;
    }

    public function getSourceType(): ?string
    {
        return $this->getData(self::SOURCE_TYPE);
    }

    public function setSourceType(?string $type): ProfileInterface
    {
        $this->setData(self::SOURCE_TYPE, $type);

        return $this;
    }

    public function getExecutionType(): ?string
    {
        return $this->getData(self::EXECUTION_TYPE);
    }

    public function setExecutionType(?string $executionType): ProfileInterface
    {
        $this->setData(self::EXECUTION_TYPE, $executionType);

        return $this;
    }

    public function getSchedule(): ?ScheduleInterface
    {
        return $this->getData(self::SCHEDULE);
    }

    public function setSchedule(?ScheduleInterface $schedule): ProfileInterface
    {
        $this->setData(self::SCHEDULE, $schedule);

        return $this;
    }

    public function getOrderActions(): ?array
    {
        return (array)$this->getData(self::ORDER_ACTIONS);
    }

    public function setOrderActions(?array $actions): ProfileInterface
    {
        $this->setData(self::ORDER_ACTIONS, $actions);

        return $this;
    }
}

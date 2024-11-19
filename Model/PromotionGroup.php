<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model;

use Kodano\Promotion\Api\Data\PromotionGroupInterface;
use Magento\Framework\Model\AbstractModel;

class PromotionGroup extends AbstractModel implements PromotionGroupInterface
{
    public function _construct()
    {
        $this->_init(\Kodano\Promotion\Model\ResourceModel\PromotionGroup::class);
    }

    public function getGroupId(): ?int
    {
        $id = $this->getData(self::GROUP_ID);

        return $id ? (int) $id : null;
    }

    public function setGroupId(int $groupId): PromotionGroupInterface
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }

    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    public function setName($name): PromotionGroupInterface
    {
        return $this->setData(self::NAME, $name);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): PromotionGroupInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt(string $updatedAt): PromotionGroupInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}

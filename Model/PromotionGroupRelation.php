<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model;

use Kodano\Promotion\Api\Data\PromotionGroupRelationInterface;
use Magento\Framework\Model\AbstractModel;

class PromotionGroupRelation extends AbstractModel implements PromotionGroupRelationInterface
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel\PromotionGroupRelation::class);
    }

    public function getRelationId(): ?int
    {
        $id = $this->getData(self::RELATION_ID);
        return $id ? (int) $id : null;
    }

    public function setRelationId(int $id): PromotionGroupRelationInterface
    {
        return $this->setData(self::RELATION_ID, $id);
    }

    public function getPromotionId(): int
    {
        return (int) $this->getData(self::PROMOTION_ID);
    }

    public function setPromotionId(int $promotionId): PromotionGroupRelationInterface
    {
        return $this->setData(self::PROMOTION_ID, $promotionId);
    }

    public function getGroupId(): int
    {
        return (int) $this->getData(self::GROUP_ID);
    }

    public function setGroupId(int $groupId): PromotionGroupRelationInterface
    {
        return $this->setData(self::GROUP_ID, $groupId);
    }
}

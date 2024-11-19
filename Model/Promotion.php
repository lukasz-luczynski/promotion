<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model;

use Kodano\Promotion\Api\Data\PromotionInterface;
use Magento\Framework\Model\AbstractModel;

class Promotion extends AbstractModel implements PromotionInterface
{
    public function _construct()
    {
        $this->_init(ResourceModel\Promotion::class);
    }

    public function getPromotionId(): ?int
    {
        $id = $this->getData(self::PROMOTION_ID);

        return $id ? (int) $id : null;
    }

    public function setPromotionId(int $promotionId): PromotionInterface
    {
        return $this->setData(self::PROMOTION_ID, $promotionId);
    }

    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    public function setName(string $name): PromotionInterface
    {
        return $this->setData(self::NAME, $name);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): PromotionInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt($updatedAt): PromotionInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}


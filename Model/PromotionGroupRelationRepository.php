<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model;

use Kodano\Promotion\Api\Data\PromotionGroupRelationInterface;
use Kodano\Promotion\Api\Data\PromotionGroupRelationInterfaceFactory;
use Kodano\Promotion\Api\PromotionGroupRelationRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;

class PromotionGroupRelationRepository implements PromotionGroupRelationRepositoryInterface
{
    public function __construct(
        private readonly PromotionGroupRelationInterfaceFactory $relationInterfaceFactory,
        private readonly \Kodano\Promotion\Model\ResourceModel\PromotionGroupRelation $promotionGroupRelationResource
    ) {
    }

    public function create(int $promotionId, int $groupId): PromotionGroupRelationInterface
    {
        $relation = $this->relationInterfaceFactory->create()
            ->setPromotionId($promotionId)
            ->setGroupId($groupId);

        $this->promotionGroupRelationResource->save($relation);

        return $relation;
    }

    public function save(PromotionGroupRelationInterface $userVendorRelation): PromotionGroupRelationInterface
    {
        try {
            $this->promotionGroupRelationResource->save($userVendorRelation);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $userVendorRelation;
    }

    public function getByGroupId(int $groupId): PromotionGroupRelationInterface
    {
        $relation = $this->relationInterfaceFactory->create();
        $this->promotionGroupRelationResource->load($relation, $groupId, 'group_id');

        return $relation;
    }

    public function delete(PromotionGroupRelationInterface $relation): bool
    {
        try {
            $this->promotionGroupRelationResource->delete($relation);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return true;
    }
}

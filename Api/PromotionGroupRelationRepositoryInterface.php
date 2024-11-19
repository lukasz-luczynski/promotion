<?php
declare(strict_types=1);

namespace Kodano\Promotion\Api;

use Kodano\Promotion\Api\Data\PromotionGroupRelationInterface;

interface PromotionGroupRelationRepositoryInterface
{
    public function create(int $promotionId, int $groupId): PromotionGroupRelationInterface;

    public function save(PromotionGroupRelationInterface $userVendorRelation): PromotionGroupRelationInterface;

    public function getByGroupId(int $groupId): PromotionGroupRelationInterface;

    public function delete(PromotionGroupRelationInterface $relation): bool;
}

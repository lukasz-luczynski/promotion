<?php
declare(strict_types=1);

namespace Kodano\Promotion\Api\Data;

interface PromotionGroupRelationInterface
{
    const RELATION_ID = 'relation_id';
    const PROMOTION_ID = 'promotion_id';
    const GROUP_ID = 'group_id';

    public function getRelationId(): ?int;

    public function setRelationId(int $id): self;

    public function getPromotionId(): int;

    public function setPromotionId(int $promotionId): self;

    public function getGroupId(): int;

    public function setGroupId(int $groupId): self;
}

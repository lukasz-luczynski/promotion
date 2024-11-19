<?php
declare(strict_types=1);

namespace Kodano\Promotion\Api\Data;

interface PromotionGroupInterface
{
    const GROUP_ID = 'group_id';
    const NAME = 'name';
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

    /**
     * @return int|null
     */
    public function getGroupId(): ?int;

    /**
     * @param int $groupId
     * @return $this
     */
    public function setGroupId(int $groupId): self;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string;

    /**
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt(string $createdAt): self;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): self;
}


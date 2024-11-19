<?php
declare(strict_types=1);

namespace Kodano\Promotion\Api;

interface PromotionGroupRepositoryInterface
{
    /**
     * @param \Kodano\Promotion\Api\Data\PromotionGroupInterface $promotionGroup
     * @return \Kodano\Promotion\Api\Data\PromotionGroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Kodano\Promotion\Api\Data\PromotionGroupInterface $promotionGroup
    ): \Kodano\Promotion\Api\Data\PromotionGroupInterface;

    /**
     * @param int $groupId
     * @return \Kodano\Promotion\Api\Data\PromotionGroupInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get(int $groupId): \Kodano\Promotion\Api\Data\PromotionGroupInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Kodano\Promotion\Api\Data\PromotionGroupSearchResultsInterface
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ): \Kodano\Promotion\Api\Data\PromotionGroupSearchResultsInterface;

    /**
     * @param \Kodano\Promotion\Api\Data\PromotionGroupInterface $promotionGroup
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Kodano\Promotion\Api\Data\PromotionGroupInterface $promotionGroup): bool;

    /**
     * @param int $groupId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $groupId): bool;
}

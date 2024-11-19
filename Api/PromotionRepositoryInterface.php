<?php
declare(strict_types=1);

namespace Kodano\Promotion\Api;

interface PromotionRepositoryInterface
{
    /**
     * @param \Kodano\Promotion\Api\Data\PromotionInterface $promotion
     * @return \Kodano\Promotion\Api\Data\PromotionInterface
     * @throws  \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Kodano\Promotion\Api\Data\PromotionInterface $promotion
    ): \Kodano\Promotion\Api\Data\PromotionInterface;

    /**
     * @param int $promotionId
     * @return \Kodano\Promotion\Api\Data\PromotionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get(int $promotionId): \Kodano\Promotion\Api\Data\PromotionInterface;

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Kodano\Promotion\Api\Data\PromotionSearchResultsInterface
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    ): \Kodano\Promotion\Api\Data\PromotionSearchResultsInterface;

    /**
     * @param \Kodano\Promotion\Api\Data\PromotionInterface $promotion
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Kodano\Promotion\Api\Data\PromotionInterface $promotion): bool;

    /**
     * @param int $promotionId
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById(int $promotionId): bool;
}

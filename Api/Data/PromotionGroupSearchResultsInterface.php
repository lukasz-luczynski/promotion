<?php
declare(strict_types=1);

namespace Kodano\Promotion\Api\Data;

interface PromotionGroupSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Kodano\Promotion\Api\Data\PromotionGroupInterface[]
     */
    public function getItems();

    /**
     * @param \Kodano\Promotion\Api\Data\PromotionGroupInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}


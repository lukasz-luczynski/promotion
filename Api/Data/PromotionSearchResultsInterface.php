<?php
declare(strict_types=1);

namespace Kodano\Promotion\Api\Data;

interface PromotionSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Kodano\Promotion\Api\Data\PromotionInterface[]
     */
    public function getItems();

    /**
     * @param \Kodano\Promotion\Api\Data\PromotionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}


<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model;

use Kodano\Promotion\Api\Data\PromotionInterface;
use Kodano\Promotion\Api\Data\PromotionInterfaceFactory;
use Kodano\Promotion\Api\Data\PromotionSearchResultsInterface;
use Kodano\Promotion\Api\Data\PromotionSearchResultsInterfaceFactory;
use Kodano\Promotion\Api\PromotionRepositoryInterface;
use Kodano\Promotion\Model\ResourceModel\Promotion as ResourcePromotion;
use Kodano\Promotion\Model\ResourceModel\Promotion\CollectionFactory as PromotionCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PromotionRepository implements PromotionRepositoryInterface
{
    public function __construct(
        private readonly ResourcePromotion $resource,
        private readonly PromotionInterfaceFactory $promotionFactory,
        private readonly PromotionCollectionFactory $promotionCollectionFactory,
        private readonly PromotionSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor
    ) {
    }

    public function save(PromotionInterface $promotion): PromotionInterface
    {
        try {
            $this->resource->save($promotion);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the promotion: %1',
                $exception->getMessage()
            ));
        }
        return $promotion;
    }

    public function get(int $promotionId): PromotionInterface
    {
        $promotion = $this->promotionFactory->create();
        $this->resource->load($promotion, $promotionId);
        if (!$promotion->getId()) {
            throw new NoSuchEntityException(__('Promotion with id "%1" does not exist.', $promotionId));
        }
        return $promotion;
    }

    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ): PromotionSearchResultsInterface {
        $collection = $this->promotionCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete(PromotionInterface $promotion): bool
    {
        try {
            $this->resource->delete($promotion);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Promotion: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById(int $promotionId): bool
    {
        return $this->delete($this->get($promotionId));
    }
}


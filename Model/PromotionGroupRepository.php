<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model;

use Kodano\Promotion\Api\Data\PromotionGroupInterface;
use Kodano\Promotion\Api\Data\PromotionGroupInterfaceFactory;
use Kodano\Promotion\Api\Data\PromotionGroupSearchResultsInterface;
use Kodano\Promotion\Api\Data\PromotionGroupSearchResultsInterfaceFactory;
use Kodano\Promotion\Api\PromotionGroupRepositoryInterface;
use Kodano\Promotion\Model\ResourceModel\PromotionGroup as ResourcePromotionGroup;
use Kodano\Promotion\Model\ResourceModel\PromotionGroup\CollectionFactory as PromotionGroupCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PromotionGroupRepository implements PromotionGroupRepositoryInterface
{
    public function __construct(
        private readonly ResourcePromotionGroup $resource,
        private readonly PromotionGroupInterfaceFactory $promotionGroupFactory,
        private readonly PromotionGroupCollectionFactory $promotionGroupCollectionFactory,
        private readonly PromotionGroupSearchResultsInterfaceFactory $searchResultsFactory,
        private readonly CollectionProcessorInterface $collectionProcessor
    ) {
    }

    public function save(PromotionGroupInterface $promotionGroup): PromotionGroupInterface
    {
        try {
            $this->resource->save($promotionGroup);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the promotionGroup: %1',
                $exception->getMessage()
            ));
        }
        return $promotionGroup;
    }

    public function get(int $groupId): PromotionGroupInterface
    {
        $promotionGroup = $this->promotionGroupFactory->create();
        $this->resource->load($promotionGroup, $groupId);
        if (!$promotionGroup->getId()) {
            throw new NoSuchEntityException(__('PromotionGroup with id "%1" does not exist.', $groupId));
        }
        return $promotionGroup;
    }

    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ): PromotionGroupSearchResultsInterface {
        $collection = $this->promotionGroupCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete(PromotionGroupInterface $promotionGroup): bool
    {
        try {
            $this->resource->delete($promotionGroup);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the PromotionGroup: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById(int $groupId): bool
    {
        return $this->delete($this->get($groupId));
    }
}


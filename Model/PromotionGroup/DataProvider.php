<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model\PromotionGroup;

use Kodano\Promotion\Model\PromotionGroup;
use Kodano\Promotion\Model\PromotionGroupRelation;
use Kodano\Promotion\Model\ResourceModel\Promotion\Collection;
use Kodano\Promotion\Model\ResourceModel\PromotionGroup\CollectionFactory;
use Kodano\Promotion\Model\ResourceModel\PromotionGroupRelation\CollectionFactory as RelationCollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $collectionFactory,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly RelationCollectionFactory $relationCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData(): ?array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var PromotionGroup $promotion */
        foreach ($items as $promotion) {
            $this->loadedData[$promotion->getId()] = $promotion->getData();

            $relationCollection = $this->relationCollectionFactory->create()
                ->addFieldToFilter('group_id', ['eq' => $promotion->getGroupId()]);

            /** @var PromotionGroupRelation $relation */
            foreach ($relationCollection as $relation) {
                $this->loadedData[$promotion->getId()]['promotion_ids'][] = (string) $relation->getPromotionId();
            }
        }
        $data = $this->dataPersistor->get('kodano_promotion');

        if (!empty($data)) {
            $promotion = $this->collection->getNewEmptyItem();
            $promotion->setData($data);
            $this->loadedData[$promotion->getId()] = $promotion->getData();
            $this->dataPersistor->clear('kodano_promotion');
        }

        return $this->loadedData;
    }
}


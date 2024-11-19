<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model\Promotion;

use Kodano\Promotion\Model\Promotion;
use Kodano\Promotion\Model\ResourceModel\Promotion\Collection;
use Kodano\Promotion\Model\ResourceModel\Promotion\CollectionFactory;
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
        /** @var Promotion $promotion */
        foreach ($items as $promotion) {
            $this->loadedData[$promotion->getId()] = $promotion->getData();
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


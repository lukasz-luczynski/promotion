<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model\Source;

use Kodano\Promotion\Model\ResourceModel\Promotion\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class Promotion implements OptionSourceInterface
{
    public function __construct(
        private readonly CollectionFactory $promotionCollectionFactory
    ) {
    }

    public function toOptionArray(): array
    {
        $options = [];
        $collection = $this->promotionCollectionFactory->create();
        /** @var \Kodano\Promotion\Model\Promotion $promotion */
        foreach ($collection as $promotion) {
            $options[] = [
                'value' => $promotion->getPromotionId(),
                'label' => $promotion->getName()
            ];
        }

        return $options;
    }
}

<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model\ResourceModel\PromotionGroup;

use Kodano\Promotion\Api\Data\PromotionGroupInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Kodano\Promotion\Model\PromotionGroup;

class Collection extends AbstractCollection
{
    protected $_idFieldName = PromotionGroupInterface::GROUP_ID;

    protected function _construct(): void
    {
        $this->_init(
            PromotionGroup::class,
            \Kodano\Promotion\Model\ResourceModel\PromotionGroup::class
        );
    }
}

<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model\ResourceModel\Promotion;

use Kodano\Promotion\Api\Data\PromotionInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Kodano\Promotion\Model\Promotion;

class Collection extends AbstractCollection
{
    protected $_idFieldName = PromotionInterface::PROMOTION_ID;

    protected function _construct(): void
    {
        $this->_init(
            Promotion::class,
            \Kodano\Promotion\Model\ResourceModel\Promotion::class
        );
    }
}

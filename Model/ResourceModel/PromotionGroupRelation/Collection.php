<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model\ResourceModel\PromotionGroupRelation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Kodano\Promotion\Model\PromotionGroupRelation;

class Collection extends AbstractCollection
{
    protected function _construct(): void
    {
        $this->_init(
            PromotionGroupRelation::class,
            \Kodano\Promotion\Model\ResourceModel\PromotionGroupRelation::class
        );
    }
}

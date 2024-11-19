<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model\ResourceModel;

use Kodano\Promotion\Api\Data\PromotionGroupInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PromotionGroup extends AbstractDb
{
    const MAIN_TABLE = 'kodano_promotion_group';

    protected function _construct(): void
    {
        $this->_init(self::MAIN_TABLE, PromotionGroupInterface::GROUP_ID);
    }
}

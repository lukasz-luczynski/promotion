<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model\ResourceModel;

use Kodano\Promotion\Api\Data\PromotionInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Promotion extends AbstractDb
{
    const MAIN_TABLE = 'kodano_promotion';

    protected function _construct(): void
    {
        $this->_init(self::MAIN_TABLE, PromotionInterface::PROMOTION_ID);
    }
}

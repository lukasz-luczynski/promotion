<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PromotionGroupRelation extends AbstractDb
{
    const MAIN_TABLE = 'kodano_promotion_group_relation';

    const ID_FIELD_NAME = 'relation_id';

    protected function _construct(): void
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}

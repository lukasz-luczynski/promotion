<?php
declare(strict_types=1);

namespace Kodano\Promotion\Model;

use Kodano\Promotion\Api\Data\PromotionSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class PromotionSearchResults extends SearchResults implements PromotionSearchResultsInterface
{

}

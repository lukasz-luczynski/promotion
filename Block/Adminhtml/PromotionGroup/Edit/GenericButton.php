<?php
declare(strict_types=1);

namespace Kodano\Promotion\Block\Adminhtml\PromotionGroup\Edit;

use Magento\Backend\Block\Widget\Context;

abstract class GenericButton
{
    public function __construct(
        private readonly Context $context
    ) {
    }

    public function getGroupId(): int
    {
        return (int) $this->context->getRequest()->getParam('group_id');
    }

    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}

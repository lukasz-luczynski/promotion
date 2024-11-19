<?php
declare(strict_types=1);

namespace Kodano\Promotion\Block\Adminhtml\Promotion\Edit;

use Magento\Backend\Block\Widget\Context;

abstract class GenericButton
{
    public function __construct(
        private readonly Context $context
    ) {
    }

    public function getPromotionId(): int
    {
        return (int) $this->context->getRequest()->getParam('promotion_id');
    }

    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}

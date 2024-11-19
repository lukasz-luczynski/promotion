<?php
declare(strict_types=1);

namespace Kodano\Promotion\Controller\Adminhtml\Promotion;

use Kodano\Promotion\Api\Data\PromotionInterfaceFactory;
use Kodano\Promotion\Api\PromotionRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    public const ADMIN_RESOURCE = 'Kodano_Promotion::Promotion_view';

    public function __construct(
        Context $context,
        private readonly PromotionRepositoryInterface $promotionRepository,
        private readonly PromotionInterfaceFactory $promotionFactory,
        private readonly Registry $registry,
        private readonly PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $id = $this->getRequest()->getParam('promotion_id');

        try {
            $promotion = $this->promotionRepository->get((int) $id);
        } catch (LocalizedException $e) {
            $promotion = $this->promotionFactory->create();
        }

        $this->registry->register('bayer_vendor', $promotion);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Promotions'));
        $resultPage->getConfig()->getTitle()->prepend($promotion->getId() ? __('Edit Promotion %1', $promotion->getId()) : __('New Promotion'));
        return $resultPage;
    }
}

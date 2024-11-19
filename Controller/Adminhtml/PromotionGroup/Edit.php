<?php
declare(strict_types=1);

namespace Kodano\Promotion\Controller\Adminhtml\PromotionGroup;

use Kodano\Promotion\Api\Data\PromotionGroupInterfaceFactory;
use Kodano\Promotion\Api\PromotionGroupRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    public const ADMIN_RESOURCE = 'Kodano_Promotion::PromotionGroup_view';

    public function __construct(
        Context $context,
        private readonly PromotionGroupRepositoryInterface $promotionGroupRepository,
        private readonly PromotionGroupInterfaceFactory $promotionGroupFactory,
        private readonly Registry $registry,
        private readonly PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $id = $this->getRequest()->getParam('group_id');

        try {
            $promotionGroup = $this->promotionGroupRepository->get((int) $id);
        } catch (LocalizedException $e) {
            $promotionGroup = $this->promotionGroupFactory->create();
        }

        $this->registry->register('bayer_vendor', $promotionGroup);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Promotions'));
        $resultPage->getConfig()->getTitle()->prepend($promotionGroup->getId() ? __('Edit Promotion %1', $promotionGroup->getId()) : __('New Promotion'));
        return $resultPage;
    }
}

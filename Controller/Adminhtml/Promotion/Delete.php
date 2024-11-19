<?php
declare(strict_types=1);

namespace Kodano\Promotion\Controller\Adminhtml\Promotion;

use Kodano\Promotion\Api\PromotionRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    public const ADMIN_RESOURCE = 'Kodano_Promotion::Promotion_delete';

    public function __construct(
        Context $context,
        private readonly PromotionRepositoryInterface $promotionRepository
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('promotion_id');
        if ($id) {
            try {
                $this->promotionRepository->deleteById((int) $id);
                $this->messageManager->addSuccessMessage(__('You deleted the Promotion.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['promotion_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a Promotion to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}


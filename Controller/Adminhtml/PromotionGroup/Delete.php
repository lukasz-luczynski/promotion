<?php
declare(strict_types=1);

namespace Kodano\Promotion\Controller\Adminhtml\PromotionGroup;

use Kodano\Promotion\Api\PromotionGroupRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    public const ADMIN_RESOURCE = 'Kodano_Promotion::PromotionGroup_delete';

    public function __construct(
        Context $context,
        private readonly PromotionGroupRepositoryInterface $promotionGroupRepository
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('group_id');
        if ($id) {
            try {
                $this->promotionGroupRepository->deleteById((int) $id);
                $this->messageManager->addSuccessMessage(__('You deleted the Promotion Group.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['group_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a Promotion Group to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}


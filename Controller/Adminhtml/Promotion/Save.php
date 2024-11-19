<?php
declare(strict_types=1);

namespace Kodano\Promotion\Controller\Adminhtml\Promotion;

use Kodano\Promotion\Api\Data\PromotionInterfaceFactory;
use Kodano\Promotion\Api\PromotionRepositoryInterface;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    public const ADMIN_RESOURCE = 'Kodano_Promotion::Promotion_save';

    public function __construct(
        Context $context,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly PromotionRepositoryInterface $promotionRepository,
        private readonly PromotionInterfaceFactory $promotionFactory
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $resultRedirect->setPath('*/*/');

        }
        $id = $this->getRequest()->getParam('promotion_id');
        $promotion = $this->promotionFactory->create();

        if ($id) {
            try {
                $promotion = $this->promotionRepository->get((int) $id);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(__('This Promotion no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        }

        $promotion->setData($data);

        try {
            $this->promotionRepository->save($promotion);
            $this->messageManager->addSuccessMessage(__('You saved the Promotion.'));
            $this->dataPersistor->clear('kodano_promotion');

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['promotion_id' => $promotion->getId()]);
            }
            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Promotion.'));
        }

        $this->dataPersistor->set('kodano_promotion', $data);
        return $resultRedirect->setPath('*/*/edit', ['promotion_id' => $this->getRequest()->getParam('promotion_id')]);
    }
}

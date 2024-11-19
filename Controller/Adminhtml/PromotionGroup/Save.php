<?php
declare(strict_types=1);

namespace Kodano\Promotion\Controller\Adminhtml\PromotionGroup;

use Kodano\Promotion\Api\Data\PromotionGroupInterfaceFactory;
use Kodano\Promotion\Api\PromotionGroupRelationRepositoryInterface;
use Kodano\Promotion\Api\PromotionGroupRepositoryInterface;
use Exception;
use Kodano\Promotion\Model\ResourceModel\PromotionGroupRelation\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends Action
{
    public const ADMIN_RESOURCE = 'Kodano_Promotion::PromotionGroup_save';

    public function __construct(
        Context $context,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly PromotionGroupRepositoryInterface $promotionGroupRepository,
        private readonly PromotionGroupInterfaceFactory $promotionGroupFactory,
        private readonly PromotionGroupRelationRepositoryInterface $promotionGroupRelationRepository,
        private readonly CollectionFactory $relationCollectionFactory
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
        $id = $this->getRequest()->getParam('group_id');
        $promotionGroup = $this->promotionGroupFactory->create();

        if ($id) {
            try {
                $promotionGroup = $this->promotionGroupRepository->get((int) $id);

                $relationCollection = $this->relationCollectionFactory->create()
                    ->addFieldToFilter('group_id', ['eq' => $id]);

                foreach ($relationCollection as $relation) {
                    $this->promotionGroupRelationRepository->delete($relation);
                }

            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage(__('This Promotion Group no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        }

        $promotionGroup->setData($data);

        try {
            $this->promotionGroupRepository->save($promotionGroup);
            $this->messageManager->addSuccessMessage(__('You saved the Promotion Group.'));
            $this->dataPersistor->clear('kodano_promotion_group');

            if (isset($data['promotion_ids'])) {
                foreach ($data['promotion_ids'] as $promotion_id) {
                    $this->promotionGroupRelationRepository->create(
                        (int) $promotion_id, (int) $promotionGroup->getGroupId()
                    );
                }
            }

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['group_id' => $promotionGroup->getId()]);
            }
            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Promotion Group.'));
        }

        $this->dataPersistor->set('kodano_promotion_group', $data);
        return $resultRedirect->setPath('*/*/edit', ['group_id' => $this->getRequest()->getParam('group_id')]);
    }
}

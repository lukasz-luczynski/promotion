<?php
declare(strict_types=1);

namespace Kodano\Promotion\Test\Unit\Model;

use Kodano\Promotion\Api\Data\PromotionInterfaceFactory;
use Kodano\Promotion\Api\Data\PromotionSearchResultsInterface;
use Kodano\Promotion\Api\Data\PromotionSearchResultsInterfaceFactory;
use Kodano\Promotion\Model\Promotion;
use Kodano\Promotion\Model\PromotionRepository;
use Kodano\Promotion\Model\ResourceModel\Promotion as ResourcePromotion;
use Kodano\Promotion\Model\ResourceModel\Promotion\Collection;
use Kodano\Promotion\Model\ResourceModel\Promotion\CollectionFactory as PromotionCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\TestCase;

class PromotionRepositoryTest extends TestCase
{
    private PromotionRepository $promotionRepository;
    private $resourceMock;
    private $promotionFactoryMock;
    private $promotionCollectionFactoryMock;
    private $searchResultsFactoryMock;
    private $collectionProcessorMock;

    protected function setUp(): void
    {
        $this->resourceMock = $this->createMock(ResourcePromotion::class);
        $this->promotionFactoryMock = $this->createMock(PromotionInterfaceFactory::class);
        $this->promotionCollectionFactoryMock = $this->createMock(PromotionCollectionFactory::class);
        $this->searchResultsFactoryMock = $this->createMock(PromotionSearchResultsInterfaceFactory::class);
        $this->collectionProcessorMock = $this->createMock(CollectionProcessorInterface::class);

        $this->promotionRepository = new PromotionRepository(
            $this->resourceMock,
            $this->promotionFactoryMock,
            $this->promotionCollectionFactoryMock,
            $this->searchResultsFactoryMock,
            $this->collectionProcessorMock
        );
    }

    public function testSaveSuccess()
    {
        $promotionMock = $this->createMock(Promotion::class);

        $this->resourceMock->expects($this->once())
            ->method('save')
            ->with($promotionMock);

        $this->assertSame($promotionMock, $this->promotionRepository->save($promotionMock));
    }

    public function testSaveThrowsCouldNotSaveException()
    {
        $promotionMock = $this->createMock(Promotion::class);

        $this->resourceMock->expects($this->once())
            ->method('save')
            ->willThrowException(new \Exception('Database error'));

        $this->expectException(CouldNotSaveException::class);
        $this->expectExceptionMessage('Could not save the promotion: Database error');

        $this->promotionRepository->save($promotionMock);
    }

    public function testGetSuccess()
    {
        $promotionId = 1;
        $promotionMock = $this->createMock(Promotion::class);

        $this->promotionFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($promotionMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($promotionMock, $promotionId);

        $promotionMock->expects($this->once())
            ->method('getId')
            ->willReturn($promotionId);

        $this->assertSame($promotionMock, $this->promotionRepository->get($promotionId));
    }

    public function testGetThrowsNoSuchEntityException()
    {
        $promotionId = 123;
        $promotionMock = $this->createMock(Promotion::class);

        $this->promotionFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($promotionMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($promotionMock, $promotionId);

        $promotionMock->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $this->expectException(NoSuchEntityException::class);
        $this->expectExceptionMessage('Promotion with id "123" does not exist.');

        $this->promotionRepository->get($promotionId);
    }

    public function testGetListSuccess()
    {
        $criteriaMock = $this->createMock(SearchCriteriaInterface::class);
        $collectionMock = $this->createMock(Collection::class);
        $searchResultsMock = $this->createMock(PromotionSearchResultsInterface::class);

        $this->promotionCollectionFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($collectionMock);

        $this->collectionProcessorMock->expects($this->once())
            ->method('process')
            ->with($criteriaMock, $collectionMock);

        $collectionMock->expects($this->once())
            ->method('getItems')
            ->willReturn(['item1', 'item2']);

        $collectionMock->expects($this->once())
            ->method('getSize')
            ->willReturn(2);

        $this->searchResultsFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($searchResultsMock);

        $searchResultsMock->expects($this->once())
            ->method('setSearchCriteria')
            ->with($criteriaMock);

        $searchResultsMock->expects($this->once())
            ->method('setItems')
            ->with(['item1', 'item2']);

        $searchResultsMock->expects($this->once())
            ->method('setTotalCount')
            ->with(2);

        $this->assertSame($searchResultsMock, $this->promotionRepository->getList($criteriaMock));
    }

    public function testDeleteSuccess()
    {
        $promotionMock = $this->createMock(Promotion::class);

        $this->resourceMock->expects($this->once())
            ->method('delete')
            ->with($promotionMock);

        $this->assertTrue($this->promotionRepository->delete($promotionMock));
    }

    public function testDeleteThrowsCouldNotDeleteException()
    {
        $promotionMock = $this->createMock(Promotion::class);

        $this->resourceMock->expects($this->once())
            ->method('delete')
            ->willThrowException(new \Exception('Deletion error'));

        $this->expectException(CouldNotDeleteException::class);
        $this->expectExceptionMessage('Could not delete the Promotion: Deletion error');

        $this->promotionRepository->delete($promotionMock);
    }

    public function testDeleteByIdSuccess()
    {
        $promotionId = 1;
        $promotionMock = $this->createMock(Promotion::class);

        $this->promotionFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($promotionMock);

        $this->resourceMock->expects($this->once())
            ->method('load')
            ->with($promotionMock, $promotionId);

        $promotionMock->expects($this->once())
            ->method('getId')
            ->willReturn($promotionId);

        $this->resourceMock->expects($this->once())
            ->method('delete')
            ->with($promotionMock);

        $this->assertTrue($this->promotionRepository->deleteById($promotionId));
    }
}

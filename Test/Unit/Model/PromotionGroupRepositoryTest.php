<?php
declare(strict_types=1);

namespace Kodano\Promotion\Test\Unit\Model;

use Kodano\Promotion\Api\Data\PromotionGroupInterfaceFactory;
use Kodano\Promotion\Api\Data\PromotionGroupSearchResultsInterfaceFactory;
use Kodano\Promotion\Model\PromotionGroup;
use Kodano\Promotion\Model\PromotionGroupRepository;
use Kodano\Promotion\Model\ResourceModel\PromotionGroup as ResourcePromotionGroup;
use Kodano\Promotion\Model\ResourceModel\PromotionGroup\CollectionFactory as PromotionGroupCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use PHPUnit\Framework\TestCase;

class PromotionGroupRepositoryTest extends TestCase
{
    private PromotionGroupRepository $promotionGroupRepository;
    private $resourceMock;
    private $promotionGroupFactoryMock;
    private $promotionGroupCollectionFactoryMock;
    private $searchResultsFactoryMock;
    private $collectionProcessorMock;

    protected function setUp(): void
    {
        $this->resourceMock = $this->createMock(ResourcePromotionGroup::class);
        $this->promotionGroupFactoryMock = $this->createMock(PromotionGroupInterfaceFactory::class);
        $this->promotionGroupCollectionFactoryMock = $this->createMock(PromotionGroupCollectionFactory::class);
        $this->searchResultsFactoryMock = $this->createMock(PromotionGroupSearchResultsInterfaceFactory::class);
        $this->collectionProcessorMock = $this->createMock(CollectionProcessorInterface::class);

        $this->promotionGroupRepository = new PromotionGroupRepository(
            $this->resourceMock,
            $this->promotionGroupFactoryMock,
            $this->promotionGroupCollectionFactoryMock,
            $this->searchResultsFactoryMock,
            $this->collectionProcessorMock
        );
    }

    public function testSaveSuccess(): void
    {
        $promotionGroupMock = $this->createMock(PromotionGroup::class);

        $this->resourceMock
            ->expects($this->once())
            ->method('save')
            ->with($promotionGroupMock);

        $result = $this->promotionGroupRepository->save($promotionGroupMock);

        $this->assertSame($promotionGroupMock, $result);
    }

    public function testSaveThrowsCouldNotSaveException(): void
    {
        $promotionGroupMock = $this->createMock(PromotionGroup::class);

        $this->resourceMock
            ->expects($this->once())
            ->method('save')
            ->with($promotionGroupMock)
            ->willThrowException(new \Exception('Save error'));

        $this->expectException(CouldNotSaveException::class);

        $this->promotionGroupRepository->save($promotionGroupMock);
    }

    public function testGetSuccess(): void
    {
        $promotionGroupId = 1;
        $promotionGroupMock = $this->createMock(PromotionGroup::class);

        $this->promotionGroupFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($promotionGroupMock);

        $this->resourceMock
            ->expects($this->once())
            ->method('load')
            ->with($promotionGroupMock, $promotionGroupId);

        $promotionGroupMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn($promotionGroupId);

        $result = $this->promotionGroupRepository->get($promotionGroupId);

        $this->assertSame($promotionGroupMock, $result);
    }

    public function testGetThrowsNoSuchEntityException(): void
    {
        $promotionGroupId = 1;
        $promotionGroupMock = $this->createMock(PromotionGroup::class);

        $this->promotionGroupFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($promotionGroupMock);

        $this->resourceMock
            ->expects($this->once())
            ->method('load')
            ->with($promotionGroupMock, $promotionGroupId);

        $promotionGroupMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn(null);

        $this->expectException(NoSuchEntityException::class);

        $this->promotionGroupRepository->get($promotionGroupId);
    }

    public function testDeleteSuccess(): void
    {
        $promotionGroupMock = $this->createMock(PromotionGroup::class);

        $this->resourceMock
            ->expects($this->once())
            ->method('delete')
            ->with($promotionGroupMock);

        $result = $this->promotionGroupRepository->delete($promotionGroupMock);

        $this->assertTrue($result);
    }

    public function testDeleteThrowsCouldNotDeleteException(): void
    {
        $promotionGroupMock = $this->createMock(PromotionGroup::class);

        $this->resourceMock
            ->expects($this->once())
            ->method('delete')
            ->with($promotionGroupMock)
            ->willThrowException(new \Exception('Delete error'));

        $this->expectException(CouldNotDeleteException::class);

        $this->promotionGroupRepository->delete($promotionGroupMock);
    }

    public function testDeleteByIdSuccess(): void
    {
        $promotionGroupId = 1;
        $promotionGroupMock = $this->createMock(PromotionGroup::class);

        $this->promotionGroupFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($promotionGroupMock);

        $this->resourceMock
            ->expects($this->once())
            ->method('load')
            ->with($promotionGroupMock, $promotionGroupId);

        $promotionGroupMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn($promotionGroupId);

        $this->resourceMock
            ->expects($this->once())
            ->method('delete')
            ->with($promotionGroupMock);

        $result = $this->promotionGroupRepository->deleteById($promotionGroupId);

        $this->assertTrue($result);
    }
}

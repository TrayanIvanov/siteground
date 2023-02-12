<?php

namespace App\Tests\Unit;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CalculatableItemDto;
use App\Service\CalculatableItemsDto;
use App\Service\CalculatableItemsDtoFactory;
use App\Tests\AbstractUnitTestCase;
use Doctrine\Common\Collections\ArrayCollection;
use Prophecy\Prophecy\ObjectProphecy;

class CalculatableItemsDtoFactoryTest extends AbstractUnitTestCase
{
    private ObjectProphecy|ProductRepository $productRepositoryMock;

    private CalculatableItemsDtoFactory $object;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepositoryMock = $this->prophesize(ProductRepository::class);

        $this->object = new CalculatableItemsDtoFactory($this->productRepositoryMock->reveal());
    }

    public function testBuild(): void
    {
        $inputData = ['A', 'B', 'A'];

        $product1 = $this->prophesize(Product::class);
        $product2 = $this->prophesize(Product::class);

        $this->productRepositoryMock->findOneBy(['sku' => 'A'])
            ->shouldBeCalledOnce()
            ->willReturn($product1);

        $this->productRepositoryMock->findOneBy(['sku' => 'B'])
            ->shouldBeCalledOnce()
            ->willReturn($product2);

        $calculatableItemsDto = $this->object->build($inputData);

        $this->assertInstanceOf(CalculatableItemsDto::class, $calculatableItemsDto);
        $this->assertInstanceOf(ArrayCollection::class, $calculatableItemsDto->getItems());
        $this->assertCount(2, $calculatableItemsDto->getItems());
        $this->assertInstanceOf(CalculatableItemDto::class, $calculatableItemsDto->getItems()->first());
        $this->assertInstanceOf(Product::class, $calculatableItemsDto->getItems()->first()->getProduct());
        $this->assertEquals(2, $calculatableItemsDto->getItems()->first()->getQuantity());
    }
}

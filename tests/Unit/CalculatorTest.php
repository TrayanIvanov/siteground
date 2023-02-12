<?php

namespace App\Tests\Unit;

use App\Entity\Product;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;
use App\Service\CalculatableItemDto;
use App\Service\Calculator;
use App\Tests\AbstractUnitTestCase;
use Prophecy\Prophecy\ObjectProphecy;

class CalculatorTest extends AbstractUnitTestCase
{
    private ObjectProphecy|PromotionRepository $promotionRepositoryMock;

    private Calculator $object;

    protected function setUp(): void
    {
        parent::setUp();

        $this->promotionRepositoryMock = $this->prophesize(PromotionRepository::class);

        $this->object = new Calculator($this->promotionRepositoryMock->reveal());
    }

    public function testCalculateItemNotInPromotion(): void
    {
        $product = new Product();
        $product->setPrice(70);
        $calculatableItemDto = new CalculatableItemDto();
        $calculatableItemDto->setProduct($product);
        $calculatableItemDto->setQuantity(2);

        $this->promotionRepositoryMock->findOneBy(['product' => $calculatableItemDto->getProduct()])
            ->shouldBeCalledOnce()
            ->willReturn(null);

        $price = $this->object->calculate($calculatableItemDto);

        $this->assertEquals(140, $price);
    }

    public function testCalculateItemQuantityNotEnoughForPromotion(): void
    {
        $product = new Product();
        $product->setPrice(70);
        $calculatableItemDto = new CalculatableItemDto();
        $calculatableItemDto->setProduct($product);
        $calculatableItemDto->setQuantity(2);

        $promotion = new Promotion();
        $promotion->setQuantity(3);
        $promotion->setPrice(180);
        $promotion->setProduct($product);

        $this->promotionRepositoryMock->findOneBy(['product' => $calculatableItemDto->getProduct()])
            ->shouldBeCalledOnce()
            ->willReturn($promotion);

        $price = $this->object->calculate($calculatableItemDto);

        $this->assertEquals(140, $price);
    }

    public function testCalculateItemInPromotion(): void
    {
        $product = new Product();
        $product->setPrice(70);
        $calculatableItemDto = new CalculatableItemDto();
        $calculatableItemDto->setProduct($product);
        $calculatableItemDto->setQuantity(4);

        $promotion = new Promotion();
        $promotion->setQuantity(3);
        $promotion->setPrice(180);
        $promotion->setProduct($product);

        $this->promotionRepositoryMock->findOneBy(['product' => $calculatableItemDto->getProduct()])
            ->shouldBeCalledOnce()
            ->willReturn($promotion);

        $price = $this->object->calculate($calculatableItemDto);

        $this->assertEquals(250, $price);
    }
}

<?php

namespace App\Tests\Unit;

use App\Entity\Product;
use App\Entity\Receipt;
use App\Service\CalculatableInterface;
use App\Service\CalculatableItemDto;
use App\Service\CalculatableItemsDto;
use App\Service\CheckoutHandler;
use App\Tests\AbstractUnitTestCase;
use Doctrine\Common\Collections\ArrayCollection;
use Prophecy\Prophecy\ObjectProphecy;

class CheckoutHandlerTest extends AbstractUnitTestCase
{
    private ObjectProphecy|CalculatableInterface $calculatorMock;

    private CheckoutHandler $object;

    protected function setUp(): void
    {
        parent::setUp();

        $this->calculatorMock = $this->prophesize(CalculatableInterface::class);

        $this->object = new CheckoutHandler($this->calculatorMock->reveal());
    }

    public function testHandlePurchase(): void
    {
        $product1 = new Product();
        $product1->setName('Lorem ips 1');
        $product2 = new Product();
        $product2->setName('Lorem ips 2');
        $calculatableItem1 = new CalculatableItemDto();
        $calculatableItem1->setProduct($product1);
        $calculatableItem1->setQuantity(2);
        $calculatableItem2 = new CalculatableItemDto();
        $calculatableItem2->setProduct($product2);
        $calculatableItem2->setQuantity(1);
        $calculatableItemsDto = new CalculatableItemsDto();
        $calculatableItemsDto->addItem($calculatableItem1);
        $calculatableItemsDto->addItem($calculatableItem2);

        $this->calculatorMock->calculate($calculatableItem1)
            ->shouldBeCalledOnce()
            ->willReturn(120);

        $this->calculatorMock->calculate($calculatableItem2)
            ->shouldBeCalledOnce()
            ->willReturn(50);

        $receipt = $this->object->handlePurchase($calculatableItemsDto);

        $this->assertInstanceOf(Receipt::class, $receipt);
        $this->assertEquals(170, $receipt->getTotal());
        $this->assertInstanceOf(ArrayCollection::class, $receipt->getReceiptItems());
        $this->assertCount(2, $receipt->getReceiptItems());
        $this->assertEquals(2, $receipt->getReceiptItems()->first()->getQuantity());
        $this->assertInstanceOf(Product::class, $receipt->getReceiptItems()->first()->getProduct());
        $this->assertEquals(120, $receipt->getReceiptItems()->first()->getTotal());
    }
}

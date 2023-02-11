<?php

namespace App\Service;

class CheckoutHandler
{
    private CalculatableInterface $calculator;

    public function __construct(CalculatableInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    public function handlePurchase(CalculatableItemsDto $calculatableItemsDto): ReceiptDto
    {
        $receiptDto = new ReceiptDto();
        $total = 0;

        foreach ($calculatableItemsDto->getItems() as $item) {
            $price = $this->calculator->calculate($item);

            $receiptItemDto = new ReceiptItemDto();
            $receiptItemDto->setProduct($item->getProduct());
            $receiptItemDto->setQuantity($item->getQuantity());
            $receiptItemDto->setTotal($price);

            $receiptDto->addReceiptItem($receiptItemDto);

            $total += $price;
        }
        $receiptDto->setTotal($total);

        return $receiptDto;
    }
}
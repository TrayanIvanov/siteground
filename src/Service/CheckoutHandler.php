<?php

namespace App\Service;

use App\Entity\Receipt;
use App\Entity\ReceiptItem;

class CheckoutHandler implements CheckoutableInterface
{
    private CalculatableInterface $calculator;

    public function __construct(CalculatableInterface $calculator)
    {
        $this->calculator = $calculator;
    }

    public function handlePurchase(CalculatableItemsDto $calculatableItemsDto): Receipt
    {
        $receipt = new Receipt();
        $total = 0;

        foreach ($calculatableItemsDto->getItems() as $item) {
            $price = $this->calculator->calculate($item);

            $receiptItem = new ReceiptItem();
            $receiptItem->setProduct($item->getProduct());
            $receiptItem->setQuantity($item->getQuantity());
            $receiptItem->setTotal($price);

            $receipt->addReceiptItem($receiptItem);

            $total += $price;
        }
        $receipt->setTotal($total);

        return $receipt;
    }
}

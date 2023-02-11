<?php

namespace App\Service;

use App\Repository\PromotionRepository;

class Calculator implements CalculatableInterface
{
    private PromotionRepository $promotionRepository;

    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function calculate(CalculatableItemDto $item): int
    {
        $promotion = $this->promotionRepository->findOneBy(['product' => $item->getProduct()]);

        if ($promotion === null || $promotion->getQuantity() > $item->getQuantity()) {
            $price = $item->getProduct()->getPrice() * $item->getQuantity();
        } else {
            $promotionsQuantity = intdiv($item->getQuantity(), $promotion->getQuantity());
            $leftoverQuantity = $item->getQuantity() % $promotion->getQuantity();
            $price = $promotionsQuantity * $promotion->getPrice() + $leftoverQuantity * $item->getProduct()->getPrice();
        }

        return $price;
    }
}

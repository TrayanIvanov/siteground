<?php

namespace App\Service;

use App\Repository\ProductRepository;

class CalculatableItemsDtoFactory
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function build(array $items): CalculatableItemsDto
    {
        $calculatableItemsDto = new CalculatableItemsDto();

        $itemQuantity = array_count_values($items);

        foreach ($itemQuantity as $item => $quantity) {
            $product = $this->productRepository->findOneBy(['sku' => $item]);
            $calculatableItemDto = new CalculatableItemDto();
            $calculatableItemDto->setProduct($product);
            $calculatableItemDto->setQuantity($quantity);
            $calculatableItemsDto->addItem($calculatableItemDto);
        }

        return $calculatableItemsDto;
    }
}

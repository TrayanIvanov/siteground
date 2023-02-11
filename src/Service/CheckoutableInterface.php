<?php

namespace App\Service;

interface CheckoutableInterface
{
    public function handlePurchase(CalculatableItemsDto $calculatableItemsDto): ReceiptDto;
}

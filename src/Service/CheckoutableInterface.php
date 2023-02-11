<?php

namespace App\Service;

use App\Entity\Receipt;

interface CheckoutableInterface
{
    public function handlePurchase(CalculatableItemsDto $calculatableItemsDto): Receipt;
}

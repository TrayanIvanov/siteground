<?php

namespace App\Service;

interface CalculatableInterface
{
    public function calculate(CalculatableItemDto $item): int;
}

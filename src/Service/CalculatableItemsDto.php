<?php

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;

class CalculatableItemsDto
{
    /**
     * @var ArrayCollection<int, CalculatableItemDto>
     */
    protected ArrayCollection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return ArrayCollection<int, CalculatableItemDto>
     */
    public function getItems(): ArrayCollection
    {
        return $this->items;
    }

    public function addItem(CalculatableItemDto $item): void
    {
        if ($this->items->contains($item)) {
            return;
        }

        $this->items->add($item);
    }

    public function removeItem(CalculatableItemDto $item): void
    {
        if (!$this->items->contains($item)) {
            return;
        }

        $this->items->removeElement($item);
    }
}

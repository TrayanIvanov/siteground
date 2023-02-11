<?php

namespace App\Service;

use Doctrine\Common\Collections\ArrayCollection;

class ReceiptDto
{
    /**
     * @var ArrayCollection<int, ReceiptItemDto>
     */
    protected ArrayCollection $receiptItems;

    protected int $total;

    public function __construct()
    {
        $this->receiptItems = new ArrayCollection();
    }

    /**
     * @return ArrayCollection<int, ReceiptItemDto>
     */
    public function getReceiptItems(): ArrayCollection
    {
        return $this->receiptItems;
    }

    public function addReceiptItem(ReceiptItemDto $receiptItem): void
    {
        if ($this->receiptItems->contains($receiptItem)) {
            return;
        }

        $this->receiptItems->add($receiptItem);
    }

    public function removeReceiptItem(ReceiptItemDto $receiptItem): void
    {
        if (!$this->receiptItems->contains($receiptItem)) {
            return;
        }

        $this->receiptItems->removeElement($receiptItem);
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }
}

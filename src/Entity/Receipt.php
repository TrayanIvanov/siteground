<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceiptRepository::class)]
class Receipt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\OneToMany(mappedBy: 'receipt', targetEntity: ReceiptItem::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $receiptItems;

    public function __construct()
    {
        $this->receiptItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection<int, ReceiptItem>
     */
    public function getReceiptItems(): Collection
    {
        return $this->receiptItems;
    }

    public function addReceiptItem(ReceiptItem $receiptItem): self
    {
        if (!$this->receiptItems->contains($receiptItem)) {
            $this->receiptItems->add($receiptItem);
            $receiptItem->setReceipt($this);
        }

        return $this;
    }

    public function removeReceiptItem(ReceiptItem $receiptItem): self
    {
        if ($this->receiptItems->removeElement($receiptItem)) {
            if ($receiptItem->getReceipt() === $this) {
                $receiptItem->setReceipt(null);
            }
        }

        return $this;
    }
}

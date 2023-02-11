<?php

namespace App\Form;

use App\Validator as CustomAssert;
use Symfony\Component\Validator\Constraints as Assert;

class Goods
{
    #[Assert\Sequentially([
        new Assert\NotNull,
        new Assert\NotBlank,
        new Assert\Type('string'),
        new CustomAssert\ContainsAlpha,
        new CustomAssert\Exists
    ])]
    protected string $goods;

    public function getGoods(): string
    {
        return $this->goods;
    }

    public function setGoods(string $goods): void
    {
        $this->goods = $goods;
    }
}
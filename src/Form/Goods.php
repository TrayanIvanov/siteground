<?php

namespace App\Form;

class Goods
{
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
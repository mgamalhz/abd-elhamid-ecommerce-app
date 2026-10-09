<?php

namespace App;

class Cart
{
    private array $items = [];

    public function __construct(
        private DiscountStrategy $discountStrategy
    ) {
    }

    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getSubtotal();
        }

        return $total;
    }

    public function getFinalTotal(): float
    {
        return $this->discountStrategy->apply($this->getTotal());
    }
}
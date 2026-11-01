<?php

namespace App;

class NoDiscount implements DiscountStrategy
{
    public function apply(float $total): float
    {
        return $total;
    }
}
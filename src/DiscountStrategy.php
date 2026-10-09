<?php

namespace App;

interface DiscountStrategy
{
    public function apply(float $total): float;
}
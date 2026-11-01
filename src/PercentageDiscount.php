<?php

namespace App;

use InvalidArgumentException;

class PercentageDiscount implements DiscountStrategy
{
    private float $percentage;

    public function __construct(float $percentage)
    {
        if ($percentage < 0 || $percentage > 100) {
            throw new InvalidArgumentException(
                "Percentage must be between 0 and 100."
            );
        }

        $this->percentage = $percentage;
    }

    public function apply(float $total): float
    {
        return $total - ($total * $this->percentage / 100);
    }
}

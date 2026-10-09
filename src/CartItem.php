<?php

namespace App;

use InvalidArgumentException;

class CartItem
{

    private Product $product;
    private int $quantity;

    public function __construct(Product $product, int $quantity)
    {
        if ($quantity <= 0) {
            throw new InvalidArgumentException(
                "Quantity must be greater than zero."
            );
        }

        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getSubtotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }

}
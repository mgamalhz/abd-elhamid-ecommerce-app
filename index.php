<?php

namespace App;
require __DIR__ . '/vendor/autoload.php';

// The Product Object
$product = new Product("Cocktail", 500);

// Cart item class's instantiation
$item = new CartItem($product, 2);


// Applying No discount
$cart1 = new Cart(new NoDiscount());
$cart1->addItem($item);

echo "No discount: " . $cart1->getFinalTotal() . PHP_EOL;


// Applying 10% discount
$cart2 = new Cart(new PercentageDiscount(10));
$cart2->addItem($item);

echo "10% discount: " . $cart2->getFinalTotal() . PHP_EOL;
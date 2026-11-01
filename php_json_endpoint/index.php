<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\CartItem;
use App\Models\Product;

header('Content-Type: application/json');

function respond(array $data, int $statusCode): never
{
    http_response_code($statusCode);

    echo json_encode($data, JSON_PRETTY_PRINT);

    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Check endpoint path
if ($path !== '/cart/items') {
    respond([
        'error' => 'Endpoint not found.'
    ], 404);
}

// Check HTTP method
if ($method !== 'POST') {
    header('Allow: POST');

    respond([
        'error' => 'Method not allowed.'
    ], 405);
}

// Read request body
$rawBody = file_get_contents('php://input');

$data = json_decode($rawBody, true);

// Reject malformed JSON
if (json_last_error() !== JSON_ERROR_NONE) {
    respond([
        'error' => 'Invalid JSON.'
    ], 400);
}

// Request body must be a JSON object
if (!is_array($data)) {
    respond([
        'error' => 'Request body must be a JSON object.'
    ], 400);
}

// Validate required fields
if (!array_key_exists('product_id', $data)) {
    respond([
        'error' => 'The product_id field is required.'
    ], 400);
}

if (!array_key_exists('quantity', $data)) {
    respond([
        'error' => 'The quantity field is required.'
    ], 400);
}

$productId = $data['product_id'];
$quantity = $data['quantity'];

// Validate product_id
if (!is_int($productId)) {
    respond([
        'error' => 'product_id must be an integer.'
    ], 400);
}

// Validate quantity
if (!is_int($quantity) || $quantity <= 0) {
    respond([
        'error' => 'quantity must be a positive integer.'
    ], 400);
}

// In-memory product catalog
$products = [
    1 => new Product('Laptop', 1200.00),
    2 => new Product('Keyboard', 75.00),
    3 => new Product('Mouse', 35.00),
];

// Find product
if (!array_key_exists($productId, $products)) {
    respond([
        'error' => 'Product not found.'
    ], 404);
}

$product = $products[$productId];

// Create cart item using existing OOP class
$cartItem = new CartItem($product, $quantity);

// Return response
respond([
    'message' => 'Cart item added successfully.',
    'item' => [
        'product_id' => $productId,
        'product_name' => $product->getName(),
        'quantity' => $quantity,
        'unit_price' => $product->getPrice(),
        'subtotal' => $cartItem->getSubtotal(),
    ]
], 201);

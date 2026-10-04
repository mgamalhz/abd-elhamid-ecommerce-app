```php
<?php

header('Content-Type: application/json');

// Read the request body
$body = file_get_contents('php://input');

try {
    // Decode JSON
    $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    // Malformed JSON
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error' => 'Malformed JSON'
    ]);

    exit;
}

// Validate required values
if (!isset($data['product_id'], $data['quantity'])) {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error' => 'product_id and quantity are required'
    ]);

    exit;
}

// Valid input
http_response_code(200);

echo json_encode([
    'success' => true,
    'message' => 'Product added successfully',
    'product_id' => $data['product_id'],
    'quantity' => $data['quantity']
]);
```

### Valid request

```json
{
    "product_id": 15,
    "quantity": 2
}
```

Response:

```json
{
    "success": true,
    "message": "Product added successfully",
    "product_id": 15,
    "quantity": 2
}
```

Status:

```text
200 OK
```

### Malformed JSON

Request:

```json
{
    "product_id": 15,
    "quantity": 2
```

Response:

```json
{
    "success": false,
    "error": "Malformed JSON"
}
```

Status:

```text
400 Bad Request
```

### Missing value

Request:

```json
{
    "product_id": 15
}
```

Response:

```json
{
    "success": false,
    "error": "product_id and quantity are required"
}
```

Status:

```text
400 Bad Request
```

# Add Cart Item API

## Endpoint

```http
POST /cart/items
Content-Type: application/json
```

The API uses an in-memory product catalog:

|  ID | Product  |   Price |
| --: | -------- | ------: |
|   1 | Laptop   | 1200.00 |
|   2 | Keyboard |   75.00 |
|   3 | Mouse    |   35.00 |

## Valid Request

```json
{
  "product_id": 2,
  "quantity": 3
}
```

**Response:** `201 Created`

```json
{
  "message": "Cart item added successfully.",
  "item": {
    "product_id": 2,
    "product_name": "Keyboard",
    "quantity": 3,
    "unit_price": 75,
    "subtotal": 225
  }
}
```

## Error Cases

### Invalid JSON

```text
{"product_id": 2, "quantity":
```

**Response:** `400 Bad Request`

```json
{
  "error": "Invalid JSON."
}
```

### Missing Field

```json
{
  "product_id": 2
}
```

**Response:** `400 Bad Request`

```json
{
  "error": "The quantity field is required."
}
```

### Invalid Quantity

```json
{
  "product_id": 2,
  "quantity": 0
}
```

**Response:** `400 Bad Request`

```json
{
  "error": "quantity must be a positive integer."
}
```

### Product Does Not Exist

```json
{
  "product_id": 999,
  "quantity": 1
}
```

**Response:** `404 Not Found`

```json
{
  "error": "Product not found."
}
```

### Unsupported Method

```http
GET /cart/items
```

**Response:** `405 Method Not Allowed`

```json
{
  "error": "Method not allowed."
}
```

## Run

```bash
composer install
php -S localhost:8000
```

## Pull Request

```text
PASTE_PULL_REQUEST_LINK_HERE
```

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

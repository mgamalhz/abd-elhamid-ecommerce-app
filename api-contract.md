# API Contract

## Overview

This document defines the HTTP API contract for products, carts, cart items, and orders.

The API uses JSON request and response bodies.

### Resource Naming Conventions

- Resource names are plural nouns: `products`, `carts`, `items`, and `orders`.
- Resource IDs are represented as path parameters.
- Query parameters are used for filtering collections.
- HTTP methods describe the operation being performed.
- Action verbs are avoided in endpoint names when standard CRUD semantics are sufficient.

---

# Products

## List Products

**Method:** `GET`

**Endpoint:**

```text
/products
```

**Purpose:** Retrieve a collection of products.

**Query Parameters:**

Optional filtering parameters may be supplied, for example:

```text
/products?category=electronics&minPrice=500&maxPrice=5000
```

**Request Body:** None.

**Success:**

`200 OK`

**Important Errors:**

- `400 Bad Request` — Invalid query parameter values.

---

## Create Product

**Method:** `POST`

**Endpoint:**

```text
/products
```

**Purpose:** Create a new product.

**Request Body:**

```json
{
  "name": "Mechanical Keyboard",
  "price": 2500
}
```

**Success:**

`201 Created`

**Important Errors:**

- `400 Bad Request` — Malformed JSON or invalid request structure.
- `422 Unprocessable Content` — Validation failure, such as an empty name or invalid price.
- `409 Conflict` — The product conflicts with an existing resource according to the application's business rules.

---

## Get Product

**Method:** `GET`

**Endpoint:**

```text
/products/{productId}
```

**Purpose:** Retrieve a specific product.

**Path Parameters:**

- `productId` — ID of the product to retrieve.

**Request Body:** None.

**Success:**

`200 OK`

**Important Errors:**

- `404 Not Found` — The requested product does not exist.
- `400 Bad Request` — Invalid product ID format.

---

## Update Product

**Method:** `PATCH`

**Endpoint:**

```text
/products/{productId}
```

**Purpose:** Partially update an existing product.

**Request Body:**

```json
{
  "price": 2700
}
```

Only fields that need to be changed need to be included.

**Success:**

`200 OK`

**Important Errors:**

- `400 Bad Request` — Malformed JSON or invalid request structure.
- `404 Not Found` — The requested product does not exist.
- `422 Unprocessable Content` — Validation failure.
- `409 Conflict` — The requested change conflicts with the current resource state.

---

## Delete Product

**Method:** `DELETE`

**Endpoint:**

```text
/products/{productId}
```

**Purpose:** Delete a product.

**Request Body:** None.

**Success:**

`204 No Content`

**Important Errors:**

- `404 Not Found` — The requested product does not exist.
- `409 Conflict` — The product cannot be deleted because of an existing business constraint, such as being referenced by an existing order.

---

# Carts

## Create Cart

**Method:** `POST`

**Endpoint:**

```text
/carts
```

**Purpose:** Create a new empty cart.

**Request Body:**

None.

**Success:**

`201 Created`

**Important Errors:**

- `400 Bad Request` — Invalid request.
- `409 Conflict` — Creating the cart conflicts with an existing application state.

---

## Get Cart

**Method:** `GET`

**Endpoint:**

```text
/carts/{cartId}
```

**Purpose:** Retrieve a specific cart and its current state.

**Path Parameters:**

- `cartId` — ID of the cart.

**Request Body:** None.

**Success:**

`200 OK`

**Important Errors:**

- `400 Bad Request` — Invalid cart ID format.
- `404 Not Found` — The requested cart does not exist.

---

# Cart Items

Cart items are represented as resources belonging to a specific cart.

## List Cart Items

**Method:** `GET`

**Endpoint:**

```text
/carts/{cartId}/items
```

**Purpose:** Retrieve all items belonging to a cart.

**Request Body:** None.

**Success:**

`200 OK`

**Important Errors:**

- `400 Bad Request` — Invalid cart ID format.
- `404 Not Found` — The requested cart does not exist.

---

## Add Cart Item

**Method:** `POST`

**Endpoint:**

```text
/carts/{cartId}/items
```

**Purpose:** Add a product to a cart.

**Request Body:**

```json
{
  "productId": 42,
  "quantity": 2
}
```

**Success:**

`201 Created`

**Important Errors:**

- `400 Bad Request` — Malformed JSON or invalid request structure.
- `404 Not Found` — The cart or product does not exist.
- `422 Unprocessable Content` — Invalid quantity or other validation failure.
- `409 Conflict` — The requested operation conflicts with the current cart state.

---

## Get Cart Item

**Method:** `GET`

**Endpoint:**

```text
/carts/{cartId}/items/{itemId}
```

**Purpose:** Retrieve a specific item from a cart.

**Request Body:** None.

**Success:**

`200 OK`

**Important Errors:**

- `400 Bad Request` — Invalid ID format.
- `404 Not Found` — The cart or cart item does not exist.

---

## Update Cart Item

**Method:** `PATCH`

**Endpoint:**

```text
/carts/{cartId}/items/{itemId}
```

**Purpose:** Update a cart item's quantity.

**Request Body:**

```json
{
  "quantity": 3
}
```

**Success:**

`200 OK`

**Important Errors:**

- `400 Bad Request` — Malformed JSON or invalid request structure.
- `404 Not Found` — The cart or cart item does not exist.
- `422 Unprocessable Content` — Invalid quantity.
- `409 Conflict` — The requested change conflicts with the current cart state.

---

## Remove Cart Item

**Method:** `DELETE`

**Endpoint:**

```text
/carts/{cartId}/items/{itemId}
```

**Purpose:** Remove a specific item from a cart.

**Request Body:** None.

**Success:**

`204 No Content`

**Important Errors:**

- `404 Not Found` — The cart or cart item does not exist.
- `409 Conflict` — The item cannot be removed because of a business constraint.

---

# Orders

## List Orders

**Method:** `GET`

**Endpoint:**

```text
/orders
```

**Purpose:** Retrieve orders.

**Query Parameters:**

Optional filters may be supplied, for example:

```text
/orders?status=pending
```

**Request Body:** None.

**Success:**

`200 OK`

**Important Errors:**

- `400 Bad Request` — Invalid query parameter values.

---

## Create Order

**Method:** `POST`

**Endpoint:**

```text
/orders
```

**Purpose:** Create an order from the current cart.

**Request Body:**

```json
{
  "cartId": 42
}
```

**Success:**

`201 Created`

**Important Errors:**

- `400 Bad Request` — Malformed JSON or invalid request structure.
- `404 Not Found` — The specified cart does not exist.
- `409 Conflict` — The cart cannot be converted into an order in its current state, or the request would create a duplicate order.
- `422 Unprocessable Content` — The cart cannot be ordered because it fails business validation, such as being empty.

---

## Get Order

**Method:** `GET`

**Endpoint:**

```text
/orders/{orderId}
```

**Purpose:** Retrieve a specific order.

**Request Body:** None.

**Success:**

`200 OK`

**Important Errors:**

- `400 Bad Request` — Invalid order ID format.
- `404 Not Found` — The requested order does not exist.

---

# Retry Behavior

Write operations can be retried when a client does not receive a response because of a network failure. The API contract must define whether such retries are safe.

## Create Product

```http
POST /products
```

Creating a product is not inherently idempotent. Repeating the same request may create multiple products.

Clients should therefore avoid automatically retrying the request unless an idempotency mechanism is provided.

If idempotency keys are supported, the client should send the same `Idempotency-Key` value when retrying the same logical request.

---

## Update Cart Item

```http
PATCH /carts/{cartId}/items/{itemId}
```

An update that sets the quantity to a specific value is safe to retry.

For example:

```json
{
  "quantity": 3
}
```

Sending the same request multiple times should leave the cart item with a quantity of `3`.

Therefore, clients may safely retry this operation when the update semantics are defined as setting the requested state rather than incrementing it.

---

## Remove Cart Item

```http
DELETE /carts/{cartId}/items/{itemId}
```

Deleting a resource is idempotent with respect to the final state: after the item has been successfully removed, repeating the deletion does not create or modify the item again.

A client may therefore safely retry a deletion when it is uncertain whether the first request reached the server.

The API may return `404 Not Found` if the item is already absent.

---

## Create Order

```http
POST /orders
```

Order creation requires special handling because retrying a `POST` can create duplicate orders.

Clients should send an idempotency key:

```http
Idempotency-Key: <unique-request-key>
```

When retrying the same logical order-creation request, the client must reuse the same idempotency key.

The server should recognize the previously processed request and return the original result instead of creating another order.

Without idempotency protection, clients should not automatically retry an order-creation request after an uncertain network failure.

---

# HTTP Status Code Conventions

| Status                      | Meaning                                                                   |
| --------------------------- | ------------------------------------------------------------------------- |
| `200 OK`                    | Request succeeded and a response body is returned.                        |
| `201 Created`               | A new resource was successfully created.                                  |
| `204 No Content`            | Request succeeded and no response body is returned.                       |
| `400 Bad Request`           | Request syntax or parameters are invalid.                                 |
| `404 Not Found`             | The requested resource does not exist.                                    |
| `409 Conflict`              | The request conflicts with the current state of a resource.               |
| `422 Unprocessable Content` | The request is structurally valid but fails validation or business rules. |

# Design Rules Summary

1. Resource names are plural nouns.
2. Resource IDs are represented using path parameters.
3. Query parameters are used for collection filtering.
4. Standard CRUD operations use HTTP methods rather than action verbs in URLs.
5. JSON is used for request bodies where data must be submitted.
6. `201 Created` is used when a new resource is created.
7. `204 No Content` is used for successful deletion when no response body is required.
8. Validation and business-rule failures use consistent error statuses.
9. Write operations document their retry behavior.
10. Order creation uses an idempotency key to prevent duplicate orders caused by retries.

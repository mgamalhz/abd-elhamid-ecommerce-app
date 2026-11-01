# Cart Project — Class Responsibilities

## 1. `Product`

### Responsibility

It represents a product and stores its basic information.

### Data it holds

* `name` — the product's name.
* `price` — the product's price.

### Main methods

* `__construct()` — initializes the product.
* `getName()` — returns the product's name.
* `getPrice()` — returns the product's price.

### Responsibility that does **not** belong to it

* It does not calculate cart totals or apply discounts.

---

## 2. `CartItem`

### Responsibility

It represents a product added to a cart along with its quantity.

### Data it holds

* `product` — the `Product` object.
* `quantity` — the number of units.

### Main methods

* `__construct()` — initializes the product and quantity and validates the quantity.
* `getSubtotal()` — calculates the subtotal for this item.

### Responsibility that does **not** belong to it

* It does not calculate the total of the entire cart.

---

## 3. `Cart`

### Responsibility

Manages the items in the cart and calculates the cart's total and final total after applying a discount strategy.

### Data it holds

* `items` — an array of `CartItem` objects.
* `discountStrategy` — a `DiscountStrategy` used to calculate the final total.

### Main methods

* `__construct()` — initializes the cart with a discount strategy.
* `addItem()` — adds a `CartItem` to the cart.
* `getTotal()` — calculates the total of all cart items.
* `getFinalTotal()` — applies the discount strategy to the cart total.

### Responsibility that does **not** belong to it

* It does not implement the actual discount calculation.

---

## 4. `DiscountStrategy` (Interface)

### Responsibility

It defines the common contract/implementation schema that every discount strategy must follow.

### Data it holds

* Doesn't hold any data.

### Main methods

* `apply(float $total): float` — defines how a discount strategy transforms the total.

### Responsibility that does **not** belong to it

* It does not perform a specific discount calculation itself.

---

## 5. `NoDiscount`

### Responsibility

It represents a discount strategy when no discount is applied.

### Data it holds

* Doesn't hold any data.

### Main methods

* `apply(float $total): float` — returns the total unchanged.

### Responsibility that does **not** belong to it

* It does not calculate percentage-based or other types of discounts.

---

## 6. `PercentageDiscount`

### Responsibility

It applies a percentage-based discount to a total value.

### Data it holds

* `percentage` — the discount percentage.

### Main methods

* `__construct()` — initializes and validates the percentage.
* `apply(float $total): float` — calculates the discounted total.

### Responsibility that does **not** belong to it

* It does not manage cart items or calculate the cart's original total.

---

# Quick Overview

| Class / Interface | Main Responsibility | Data Held |
| -------------------- | ------------------------------------------- | ------------------------ |
| `Product` | Represents a product | Name, price |
| `CartItem` | Represents a product and quantity in a cart | Product, quantity |
| `Cart` | Manages cart items and calculates totals | Items, discount strategy |
| `DiscountStrategy` | Defines the discount contract | None |
| `NoDiscount` | Applies no discount | None |
| `PercentageDiscount` | Applies a percentage discount | Percentage |

## Easiest and hardest responsibilities to place

* Easiest one: Product class responsibility.
* Hardest one: Cart class responsibility.

## Self-Review

After reviewing the responsibilities, I found that each class has a clearly defined responsibility, and the responsibilities are appropriately separated.

The only modification needed was adding `getName()` to the `Product` class's main methods. This method allows other parts of the application to retrieve a product's name without accessing its property directly.

No other code changes were needed because:

* `Product` only manages basic product information.
* `CartItem` handles the product quantity and its subtotal.
* `Cart` manages cart items and delegates discount calculations to a discount strategy.
* `DiscountStrategy` defines a common contract, while `NoDiscount` and `PercentageDiscount` provide specific implementations.

The separation of responsibilities is clear, and no class appears to be taking on responsibilities that belong to another class.

# 🧱 Laravel E-Commerce Backend

A modular Laravel 10 e-commerce backend, optimized for API-based headless architecture (Nuxt / React frontend).

---

## 🚀 Features
- Modular, clean domain structure.
- Spatie MediaLibrary integration for product images.
- Multi-language support (Spatie Translatable).
- Guest checkout support.
- Advanced cart, wishlist, and coupon system.
- Settings key-value store with caching.
- SEO redirects and newsletter subscriptions.

---

## 🧩 Domain Overview

| Domain | Models |
|--------|--------|
| 🛍 Product | `Product`, `Category`, `Collection`, `Attribute`, `AttributeOption`, `ProductVariant` |
| 💸 Orders | `Order`, `OrderItem`, `OrderAddress`, `Coupon` |
| 👤 Users | `User`, `Address`, `WishlistItem`, `Review` |
| ⚙️ Utilities | `Setting`, `NewsletterSubscriber`, `Redirect` |

---

## 🖼 Image Handling

All product and variant images are managed by **Spatie MediaLibrary**.

```php
$product->addMedia($request->file('image'))->toMediaCollection('images');
$product->getFirstMediaUrl('images');

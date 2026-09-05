# ⛩️ Shinigami Vault

An anime-inspired streetwear e-commerce site built with PHP and MySQL. Shinigami Vault lets customers browse and buy anime-themed apparel (oversized tees, hoodies), while a built-in admin dashboard handles product, stock, and image management.

## Features

### Customer storefront

- Account registration and login, with an optional "remember me" cookie
- Password reset / forgot-password flow
- Home page with featured products and collection highlights
- Browse by category (Oversized, Hoodies) and by curated collections
- Keyword search with live filtering
- Single product view with color/size variants, multiple images, and customer reviews
- Shopping cart with a slide-out sidebar, live item count, and add/remove functionality
- Customer profile management, including saved delivery address (city, district, province, postal code) using Sri Lanka's province/district structure
- Toast notifications for user feedback (login errors, cart updates, etc.)

### Admin dashboard

- Sidebar-based admin panel for managing the store
- Add new products with category, type, and collection assignment
- Add stock entries per product with color, size, price, and quantity
- Product image upload with type validation (JPEG/PNG/WebP) and a 5MB size limit
- Duplicate-image prevention — images are only re-uploaded for genuinely new product/color combinations

## Tech stack

- **PHP** — server-side rendering with included partials (`header.php`, `footer.php`)
- **MySQL** — via a custom `Database` wrapper class (`connection.php`, not committed — see [Setup](#setup))
- **Bootstrap 5** — layout and components, plus Bootstrap Icons
- **SweetAlert2** — alert/confirmation dialogs
- **Vanilla JavaScript** — cart, auth panel switching, and dashboard interactivity (`js/main.js`)

## Project structure

```text
ShinigamiVault/
├── assets/
│   ├── products/          # Uploaded product images
│   ├── hero.png, carousel-1.png, carousel-2.png, logo.png
├── css/
│   ├── bootstrap.css
│   └── style.css
├── js/
│   ├── main.js             # Cart, auth, and UI interactions
│   └── bootstrap.bundle.js
├── processes/               # Backend request handlers (AJAX/form targets)
│   ├── addToCartProcess.php
│   ├── customerAddressDetails.php
│   ├── customerLoginProcess.php
│   ├── customerProfileDetailsProcess.php
│   ├── customerRegisterProcess.php
│   ├── getCartCountProcess.php
│   ├── getDistrictsProcess.php
│   └── removeFromCartProcess.php
├── header.php / footer.php  # Shared layout partials
├── index.php                 # Login / register / forgot-password entry point
├── home.php                   # Storefront home page
├── search.php                  # Search and filtering
├── collection.php               # Collections listing
├── singleProductView.php         # Product detail page with reviews
├── customerProfile.php            # Customer profile and address management
├── dashboard.php                   # Admin dashboard
├── productSaveProcess.php           # Admin: create product
├── stockSaveProcess.php               # Admin: add stock + images
├── checkImages.php                     # Admin: check existing images for a product/color
├── getTypes.php                          # AJAX: fetch product types by category
└── connection.php                          # Database connection (gitignored, not included)
```

## Setup

### Prerequisites

- PHP 7.4+ with the `mysqli` extension
- A MySQL (or MariaDB) server
- A local server environment such as XAMPP, WAMP, or `php -S`

### Steps

1. Clone the repository:

   ```bash
   git clone https://github.com/ShehaniKavindi/ShinigamiVault.git
   ```

2. Create a MySQL database and import your schema (tables referenced in the code include `customer`, `product`, `inventory`, `product_images`, `type`, `category`, `collection`, `address`, `district`, `province`, among others).

3. Create a `connection.php` file in the project root defining a `Database` class with `search()` (SELECT queries) and `iud()` (insert/update/delete queries) static methods, connecting to your local database. This file is intentionally excluded from version control since it holds database credentials.

4. Serve the project with your local PHP environment, e.g.:

   ```bash
   php -S localhost:8000
   ```

5. Open `http://localhost:8000/index.php` to register or log in, and `http://localhost:8000/dashboard.php` to access the admin panel.

## Notes

- Currency is displayed in **LKR (Sri Lankan Rupees)**, and the address form is built around Sri Lanka's province/district system.
- Product images are validated for file type and size before being stored under `assets/products/`.

## Author

**Shehani Kavindi**
Software Engineer Undergraduate at Birmingham City University

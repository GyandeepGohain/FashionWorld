# FashionWorld - PHP Ecommerce Website

## Overview

FashionWorld is a PHP-based ecommerce website built with core PHP, MySQL, HTML, CSS, JavaScript, and Bootstrap.
The project includes customer authentication, product management, cart system, checkout flow, payment integration, and an admin dashboard for managing products, customers, orders, and website settings.

---

# Features

## Customer Side

* User Registration & Login
* Product Categories & Filtering
* Product Search
* Product Details Page
* Add to Cart
* Billing & Shipping Address Management
* Same as Billing Address Option
* Checkout & Payment Flow
* Order History
* Customer Dashboard
* Contact & Newsletter Subscription

## Admin Side

* Dashboard Analytics
* Product Management
* Category Management
* Customer Management
* Order Management
* Shipping & Payment Status Update
* Slider & Banner Management
* Website Settings Management
* Email Notifications for Customer Status Updates

---

# Tech Stack

* PHP
* MySQL
* HTML5
* CSS3
* JavaScript
* Bootstrap
* jQuery
* PHPMailer

---

# Project Structure

```bash
FashionWorld-ECOM/
│
├── admin/                  # Admin panel files
├── assets/                 # CSS, JS, images, uploads
├── customer/               # Customer related pages
├── payment/                # Payment gateway files
├── includes/               # Database & common includes
├── cart.php
├── checkout.php
├── customer-billing-shipping-update.php
├── product.php
├── index.php
└── README.md
```

---

# Installation Guide

## 1. Clone Repository

```bash
git clone https://github.com/YOUR_USERNAME/FashionWorld.git
```

---

## 2. Move Project

Move the project folder to:

```bash
xampp/htdocs/
```

---

## 3. Start XAMPP

Start:

* Apache
* MySQL

---

## 4. Create Database

Open:

```bash
http://localhost/phpmyadmin
```

Create database:

```sql
fashiony_ogs
```

---

## 5. Import Database

Import:

```bash
fashiony_ogs.sql
```

---

## 6. Configure Database

Open:

```bash
admin/inc/config.php
```

Update database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'fashiony_ogs');
define('DB_USER', 'root');
define('DB_PASS', '');
```

---

# Run Project

Open browser:

```bash
http://localhost/FashionWorld-ECOM/
```

Admin Panel:

```bash
http://localhost/FashionWorld-ECOM/admin/
```

---

# Admin Login

```txt
Email: admin@example.com
Password: admin
```

(Change credentials from database after setup)

---

# Important Custom Features Added

* Updated branding to FashionWorld
* Improved checkout flow
* Proceed to Shipping functionality
* Billing → Shipping auto copy checkbox
* Proper form validation before payment
* Fixed admin email trigger logic
* Removed unnecessary AI-generated files/code
* Cleaned unused assets and scripts
* GitHub-ready structure with `.gitignore`

---

# Security Improvements

* Removed sensitive API keys from repository
* Added `.gitignore`
* Excluded SQL dumps and environment files
* Cleaned unnecessary debug code

---

# Recommended `.gitignore`

```gitignore
/vendor/
/node_modules/
*.sql
.env
.DS_Store
```

---

# Future Improvements

* Razorpay Integration
* OTP Login
* Wishlist Feature
* Product Reviews
* Invoice PDF Generation
* Admin Analytics Dashboard
* Responsive UI Enhancements

---

# Author

### Gyandeep Gohain

FashionWorld Ecommerce Project

---

# License

This project is for educational and portfolio purposes only.

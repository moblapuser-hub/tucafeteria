# TU Cafeteria — Online Cafeteria Management System

Procedural PHP + MySQL + Vanilla JS/CSS. Runs on XAMPP / InfinityFree.

## Setup
1. Copy this folder to `htdocs/cafeteria/`.
2. Open phpMyAdmin → Import `database.sql`.
3. Visit `http://localhost/cafeteria/`.

## Default Admin
- Username: `admin`
- Password: `admin123`

## Flow
- Landing page → Get Started (Register) / Login
- Student logs in → Browse menu → **Add to Cart** (no redirect; cart count updates instantly)
- Click **Cart** in header → Review items → **Proceed to Place Order**
- After placing order → **Track My Order** + **Print Receipt** buttons appear
- My Orders page shows live status (Pending / Preparing / Ready / Delivered)

## Features
- Wallet top-up (JazzCash / EasyPaisa / Bank)
- Admin: manage menu items (CRUD), update order status, dashboard stats

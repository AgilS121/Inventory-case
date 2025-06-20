
# Inventory Management System (Laravel 12 + Bootstrap + K6 Test)

Sistem manajemen stok barang dengan fitur:

- Login admin & operator
- CRUD data barang
- CRUD user (admin bisa kelola operator)
- Transaksi masuk & keluar barang
- Validasi stok minimum (<10)
- Proteksi concurrency race condition (safe stock update)
- Pengujian stress test dengan K6
## Features

- 🛡️ Middleware Role Admin & Operator
- 📦 CRUD Barang
- 👥 CRUD Users (admin only)
- 🔄 CRUD Transaksi Masuk/Keluar
- ⚠️ Validasi Stok Minimum
- 🔐 Proteksi Concurrency Safe pada Update Stok
- 📊 Dashboard Statistik
- 🔬 Load Test dengan K6 untuk deteksi race condition

## Tech Stack

- PHP 8.2
- Laravel 12
- MySQL
- Bootstrap 5
- AJAX jQuery (Front-end)
- Grafana K6 (Load Test)

## Installation

git clone https://github.com/namauser/repo-inventori.git
cd repo-inventori
composer install
cp .env.example .env
php artisan key:generate

# Setting database di .env

php artisan serve
## Running Tests

Admin
- username: Agilsee
- password: admin123

Operator
- username: OpOne
- password: admin123

Operator 2
- username: OpTwo
- password: operatortwo

Operator 3
- username: OpThree
- password: operatorthree
# Install K6
choco install k6

# Jalankan load test:
k6 run test-transaksi.js

# File test-transaksi.js tersedia di root

## Authors

- Created by: Agil Pamungkas

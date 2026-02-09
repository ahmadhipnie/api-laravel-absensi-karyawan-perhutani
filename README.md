# API Absensi Laravel

## 📝 Deskripsi
API untuk sistem absensi karyawan dengan fitur clock in/out, manajemen user, filter pencarian, dan export data ke Excel/PDF.

## 🚀 Fitur
- ✅ Authentication (Register, Login, Logout) menggunakan Laravel Sanctum
- ✅ CRUD User Management
- ✅ Clock In/Out dengan foto dan lokasi GPS
- ✅ Filter absensi berdasarkan:
  - User ID
  - Status (hadir, izin, sakit, terlambat)
  - Tanggal
  - Range tanggal
  - Bulan & Tahun
  - Pencarian nama/NPK
- ✅ Export data ke Excel (CSV)
- ✅ Export data ke PDF
- ✅ Statistik absensi per user
- ✅ Kalkulasi otomatis keterlambatan
- ✅ Upload foto clock in/out

## 📋 Requirements
- PHP >= 8.2
- Composer
- MySQL/PostgreSQL
- Laravel 11.x
- Laravel Sanctum
- DomPDF

## 🔧 Installation

### 1. Clone atau Download Project
```bash
cd api-absensi-laravel
```

### 2. Install Dependencies
```bash
composer install
```

Install required packages:
```bash
composer require laravel/sanctum
composer require barryvdh/laravel-dompdf
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` dan sesuaikan database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migration & Seeding
```bash
# Buat database terlebih dahulu, lalu jalankan:
php artisan migrate

# Seed data sample (optional)
php artisan db:seed

# Atau migrate fresh dengan seed
php artisan migrate:fresh --seed
```

Data seed default:
- Admin: NPK: `ADM001`, Password: `password`
- Karyawan: NPK: `EMP001-EMP005`, Password: `password`

### 5. Storage Link
```bash
php artisan storage:link
```

### 6. Run Development Server
```bash
php artisan serve
```

API akan berjalan di: `http://localhost:8000`

## 📚 API Documentation

Dokumentasi lengkap tersedia di file [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

### Quick Start

**Base URL:** `http://localhost:8000/api`

#### 1. Register
```bash
POST /register
{
    "npk": "EMP006",
    "nama": "Test User",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### 2. Login
```bash
POST /login
{
    "npk": "EMP001",
    "password": "password"
}
```

Response akan memberikan token yang digunakan untuk endpoints lainnya.

#### 3. Clock In
```bash
POST /absensi/clock-in
Headers: Authorization: Bearer {token}
Body (form-data):
- user_id: 1
- tanggal: 2026-02-06
- clock_in_lat: -6.200000
- clock_in_long: 106.816666
- clock_in_image: [file]
```

#### 4. Get Absensi dengan Filter
```bash
GET /absensi?user_id=1&month=2&year=2026&status=terlambat
Headers: Authorization: Bearer {token}
```

#### 5. Export to Excel
```bash
GET /absensi/export/excel?month=2&year=2026
Headers: Authorization: Bearer {token}
```

#### 6. Export to PDF
```bash
GET /absensi/export/pdf?user_id=1
Headers: Authorization: Bearer {token}
```

## 🧪 Testing dengan Postman

1. Import file `Absensi_API.postman_collection.json` ke Postman
2. Set environment variables:
   - `base_url`: `http://localhost:8000/api`
   - `token`: (akan di-set otomatis setelah login)
3. Mulai testing dari folder "Auth" > "Login"
4. Token akan tersimpan otomatis di environment variable

## 📂 Struktur Project

```
app/
├── Http/
│   └── Controllers/
│       └── api/
│           ├── AbsensiController.php   # Controller absensi
│           ├── AuthController.php      # Controller authentication
│           └── UserController.php      # Controller user CRUD
└── Models/
    ├── Absensi.php                     # Model absensi
    └── User.php                        # Model user

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   └── 2026_02_06_085720_create_absensi.php
└── seeders/
    ├── DatabaseSeeder.php
    └── UserSeeder.php

routes/
└── api.php                             # API routes

resources/
└── views/
    └── pdf/
        └── absensi.blade.php           # Template PDF export
```

## 🔐 Security

- Semua password di-hash menggunakan bcrypt
- API menggunakan Laravel Sanctum untuk authentication
- Token-based authentication untuk semua protected routes
- Validasi input pada semua endpoints

## 📊 Database Schema

### Users Table
- `id` - Primary key
- `npk` - NPK karyawan (unique)
- `nama` - Nama lengkap
- `password` - Password (hashed)
- `role` - Role (admin/karyawan)
- `timestamps`

### Absensi Table
- `id` - Primary key
- `user_id` - Foreign key ke users
- `tanggal` - Tanggal absensi
- `clock_in` - Waktu masuk
- `clock_in_image` - Foto saat masuk
- `clock_in_lat/long` - Lokasi GPS masuk
- `clock_out` - Waktu keluar
- `clock_out_image` - Foto saat keluar
- `clock_out_lat/long` - Lokasi GPS keluar
- `late_duration` - Durasi terlambat (menit)
- `status` - Status (hadir/izin/sakit/terlambat)
- `timestamps`

## 🎯 Filter & Search Features

Absensi dapat difilter berdasarkan:
- `user_id` - Filter by user
- `status` - Filter by status (hadir/izin/sakit/terlambat)
- `tanggal` - Filter by specific date
- `start_date` & `end_date` - Filter by date range
- `month` & `year` - Filter by month and year
- `search` - Search by user name or NPK
- `order_by` - Sort by column (default: tanggal)
- `order_dir` - Sort direction (asc/desc)
- `per_page` - Pagination (default: 15)

## 📥 Export Features

### Excel (CSV)
```
GET /absensi/export/excel?user_id=1&month=2&year=2026
```
Menghasilkan file CSV dengan semua data absensi sesuai filter.

### PDF
```
GET /absensi/export/pdf?status=terlambat&month=2&year=2026
```
Menghasilkan file PDF dengan format landscape berisi data absensi.

## 📈 Statistics

Endpoint statistik untuk melihat ringkasan absensi per user:

```
GET /absensi/user/{userId}/stats?month=2&year=2026
```

Response:
- Total hadir
- Total terlambat
- Total izin
- Total sakit
- Total menit terlambat
- Rata-rata menit terlambat

## 🐛 Troubleshooting

Lihat file [SETUP_INSTRUCTIONS.md](SETUP_INSTRUCTIONS.md) untuk troubleshooting umum.

## 📝 License

This project is open-sourced software licensed under the MIT license.

## 👨‍💻 Author

Created for learning purposes.

---

**Happy Coding!** 🚀


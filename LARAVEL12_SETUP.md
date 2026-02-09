# Laravel 12 - Setup API & Sanctum

## Langkah-langkah Setup (WAJIB)

### 1. Install Laravel Sanctum
```bash
composer require laravel/sanctum
```

### 2. Install Laravel API (untuk mengaktifkan API routes)
```bash
php artisan install:api
```

Command ini akan:
- Membuat file `routes/api.php` (jika belum ada)
- Install dan configure Laravel Sanctum
- Menambahkan API routing ke `bootstrap/app.php`
- Membuat migration untuk personal access tokens

**ATAU** jika command `install:api` tidak tersedia, jalankan manual:

```bash
# Install Sanctum
composer require laravel/sanctum

# Publish Sanctum config & migration
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

# Run migration
php artisan migrate
```

### 3. Update bootstrap/app.php

Setelah install, pastikan `bootstrap/app.php` memiliki konfigurasi API:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',  // <-- Tambahkan ini
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Tambahkan alias untuk API throttle (optional)
        $middleware->alias([
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

### 4. Install DomPDF untuk Export PDF
```bash
composer require barryvdh/laravel-dompdf
```

### 5. Run Migrations
```bash
php artisan migrate
```

Ini akan membuat:
- Table `users`
- Table `absensi`
- Table `personal_access_tokens` (untuk Sanctum)
- Tables lainnya

### 6. Seed Database (Optional)
```bash
php artisan db:seed
```

Atau fresh migration + seed:
```bash
php artisan migrate:fresh --seed
```

### 7. Create Storage Link
```bash
php artisan storage:link
```

### 8. Clear Cache (jika ada masalah)
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### 9. Verify API Routes
```bash
php artisan route:list
```

Anda harus melihat routes dengan prefix `/api`:
- `/api/login`
- `/api/register`
- `/api/users`
- `/api/absensi/*`
- dll

### 10. Test API
```bash
php artisan serve
```

Test dengan curl atau Postman:
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "npk": "TEST001",
    "nama": "Test User",
    "password": "password",
    "password_confirmation": "password"
  }'
```

## Troubleshooting

### Error: "Target class [App\Http\Controllers\api\...] does not exist"
```bash
composer dump-autoload
```

### Error: "Route [api/*] not defined"
Pastikan `bootstrap/app.php` sudah include `api: __DIR__.'/../routes/api.php'`

### Error: "Class 'Laravel\Sanctum\...' not found"
```bash
composer require laravel/sanctum
php artisan config:clear
```

### Error saat Upload Image
```bash
php artisan storage:link
```

Di Windows, jalankan CMD/PowerShell sebagai Administrator jika gagal.

## Verification Checklist

✅ Sanctum installed: `composer show laravel/sanctum`
✅ DomPDF installed: `composer show barryvdh/laravel-dompdf`
✅ API routes aktif: `php artisan route:list | grep api`
✅ Migration berhasil: Check tables di database
✅ Storage link dibuat: Folder `public/storage` exists
✅ Server running: `php artisan serve`

Setelah semua langkah ini selesai, API Anda siap digunakan! 🚀

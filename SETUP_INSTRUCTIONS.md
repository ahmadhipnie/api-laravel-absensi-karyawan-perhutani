# Setup Instructions

## 1. Install Required Packages

Jalankan commands berikut untuk menginstall dependencies:

```bash
# Install Laravel Sanctum untuk authentication
composer require laravel/sanctum

# Install DomPDF untuk export PDF
composer require barryvdh/laravel-dompdf
```

## 2. Publish Sanctum Configuration

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

## 3. Update composer.json (jika diperlukan)

Pastikan require section di composer.json Anda memiliki:

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0",
        "laravel/sanctum": "^4.0",
        "barryvdh/laravel-dompdf": "^3.0"
    }
}
```

## 4. Migrate Database

Sebelum migrate, pastikan database sudah dibuat:

```bash
php artisan migrate
```

Jika ada error, drop semua table dan migrate ulang:

```bash
php artisan migrate:fresh
```

## 5. Create Storage Link

Untuk akses file upload (gambar absensi):

```bash
php artisan storage:link
```

## 6. Start Development Server

```bash
php artisan serve
```

Server akan berjalan di: http://localhost:8000

## 7. Testing dengan Postman

1. Import file `Absensi_API.postman_collection.json` ke Postman
2. Set environment variable `base_url` = http://localhost:8000/api
3. Register atau login untuk mendapatkan token
4. Copy token dan set ke environment variable `token`
5. Mulai testing endpoints lainnya

## Troubleshooting

### Error "Class 'Laravel\Sanctum\...' not found"
```bash
composer require laravel/sanctum
php artisan config:clear
php artisan cache:clear
```

### Error "Class 'Barryvdh\DomPDF\...' not found"
```bash
composer require barryvdh/laravel-dompdf
php artisan config:clear
```

### Error Upload Image
```bash
php artisan storage:link
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### CORS Error (jika diakses dari frontend)
Uncomment di `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->api(prepend: [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    ]);
})
```

Dan install Laravel CORS:
```bash
composer require fruitcake/laravel-cors
```

## Additional Configuration

### Set Timezone (Optional)
Di `config/app.php`:
```php
'timezone' => 'Asia/Jakarta',
```

### Set Locale (Optional)
Di `config/app.php`:
```php
'locale' => 'id',
```

Happy Coding! 🚀

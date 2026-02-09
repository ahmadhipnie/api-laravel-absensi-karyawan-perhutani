# API Absensi Laravel - Documentation

## Instalasi

### 1. Install Dependencies

```bash
composer install
composer require laravel/sanctum
composer require barryvdh/laravel-dompdf
```

### 2. Konfigurasi Environment

Copy `.env.example` ke `.env` dan sesuaikan konfigurasi database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Generate Key dan Migrate Database

```bash
php artisan key:generate
php artisan migrate
php artisan storage:link
```

### 4. Publish Sanctum Config (Optional)

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

## API Endpoints

### Base URL
```
http://localhost:8000/api
```

### Authentication

#### 1. Register
**POST** `/register`

Request Body:
```json
{
    "npk": "EMP001",
    "nama": "John Doe",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "karyawan"
}
```

Response:
```json
{
    "success": true,
    "message": "User registered successfully",
    "data": {
        "user": {
            "id": 1,
            "npk": "EMP001",
            "nama": "John Doe",
            "role": "karyawan"
        },
        "token": "1|xxxxxxxxxxxxx",
        "token_type": "Bearer"
    }
}
```

#### 2. Login
**POST** `/login`

Request Body:
```json
{
    "npk": "EMP001",
    "password": "password123"
}
```

#### 3. Logout
**POST** `/logout`

Headers:
```
Authorization: Bearer {token}
```

---

### User Management (CRUD)

**Headers untuk semua request:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

#### 1. Get All Users
**GET** `/users`

Query Parameters:
- `role` - Filter by role (admin/karyawan)
- `search` - Search by npk or nama
- `per_page` - Items per page (default: 15)
- `page` - Page number

Example:
```
GET /users?role=karyawan&search=John&per_page=10&page=1
```

#### 2. Get User by ID
**GET** `/users/{id}`

#### 3. Create User
**POST** `/users`

Request Body:
```json
{
    "npk": "EMP002",
    "nama": "Jane Smith",
    "password": "password123",
    "role": "admin"
}
```

#### 4. Update User
**PUT** `/users/{id}`

Request Body:
```json
{
    "npk": "EMP002",
    "nama": "Jane Smith Updated",
    "role": "karyawan"
}
```

#### 5. Delete User
**DELETE** `/users/{id}`

---

### Absensi Management

#### 1. Clock In
**POST** `/absensi/clock-in`

Request Body (multipart/form-data):
```
user_id: 1
tanggal: 2026-02-06
clock_in_image: [file]
clock_in_lat: -6.200000
clock_in_long: 106.816666
```

Response:
```json
{
    "success": true,
    "message": "Clock in successful",
    "data": {
        "id": 1,
        "user_id": 1,
        "tanggal": "2026-02-06",
        "clock_in": "08:30:00",
        "late_duration": 30,
        "status": "terlambat",
        "user": {
            "id": 1,
            "npk": "EMP001",
            "nama": "John Doe"
        }
    }
}
```

#### 2. Clock Out
**POST** `/absensi/clock-out/{id}`

Request Body (multipart/form-data):
```
clock_out_image: [file]
clock_out_lat: -6.200000
clock_out_long: 106.816666
```

#### 3. Get All Absensi with Filters
**GET** `/absensi`

Query Parameters:
- `user_id` - Filter by user ID
- `status` - Filter by status (hadir/izin/sakit/terlambat)
- `tanggal` - Filter by specific date (YYYY-MM-DD)
- `start_date` - Filter from date
- `end_date` - Filter to date
- `month` - Filter by month (1-12)
- `year` - Filter by year (YYYY)
- `search` - Search by user name or npk
- `order_by` - Order by field (default: tanggal)
- `order_dir` - Order direction (asc/desc, default: desc)
- `per_page` - Items per page (default: 15)

Examples:
```
GET /absensi?user_id=1&month=2&year=2026
GET /absensi?status=terlambat&start_date=2026-02-01&end_date=2026-02-28
GET /absensi?search=John&per_page=20
```

#### 4. Get Absensi by ID
**GET** `/absensi/{id}`

#### 5. Update Absensi
**PUT** `/absensi/{id}`

Request Body:
```json
{
    "status": "izin",
    "late_duration": 0
}
```

#### 6. Delete Absensi
**DELETE** `/absensi/{id}`

---

### Export Features

#### 1. Export to Excel (CSV)
**GET** `/absensi/export/excel`

Query Parameters (optional - same as Get All Absensi):
```
GET /absensi/export/excel?user_id=1&month=2&year=2026
```

Response: Downloads CSV file

#### 2. Export to PDF
**GET** `/absensi/export/pdf`

Query Parameters (optional - same as Get All Absensi):
```
GET /absensi/export/pdf?status=terlambat&month=2&year=2026
```

Response: Downloads PDF file

---

### Statistics

#### Get User Statistics
**GET** `/absensi/user/{userId}/stats`

Query Parameters:
- `month` - Filter by month (1-12)
- `year` - Filter by year (YYYY)

Example:
```
GET /absensi/user/1/stats?month=2&year=2026
```

Response:
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "npk": "EMP001",
            "nama": "John Doe",
            "role": "karyawan"
        },
        "stats": {
            "total_hadir": 15,
            "total_terlambat": 5,
            "total_izin": 2,
            "total_sakit": 1,
            "total_late_minutes": 150,
            "average_late_minutes": 30
        }
    }
}
```

---

## Testing dengan Postman

### 1. Setup Environment Variables

Buat environment di Postman dengan variables:
- `base_url`: http://localhost:8000/api
- `token`: (akan di-set setelah login)

### 2. Testing Flow

1. **Register/Login**
   - Register user baru atau login
   - Copy token dari response
   - Set sebagai environment variable `token`

2. **Test User CRUD**
   - Create user
   - Get all users
   - Update user
   - Delete user

3. **Test Absensi**
   - Clock in (pagi)
   - Clock out (sore)
   - Get absensi with filters
   - Update absensi
   - Get user statistics

4. **Test Export**
   - Export to Excel
   - Export to PDF

---

## Error Handling

Semua error response mengikuti format:

```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["Validation error message"]
    }
}
```

Common HTTP Status Codes:
- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

---

## Notes

1. **Image Upload**: 
   - Maximum file size: 2MB
   - Accepted formats: jpg, jpeg, png, gif
   - Images stored in `storage/app/public/absensi/`

2. **Late Calculation**:
   - Work start time: 08:00
   - Late duration calculated in minutes
   - Status automatically set to "terlambat" if clock in > 08:00

3. **Authentication**:
   - All endpoints (except register & login) require Bearer token
   - Token sent in Authorization header: `Bearer {token}`

4. **Pagination**:
   - Default per_page: 15
   - Response includes links and meta for pagination

5. **File Storage**:
   - Run `php artisan storage:link` to create symbolic link
   - Images accessible via `/storage/absensi/...`

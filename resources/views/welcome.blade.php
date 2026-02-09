<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>API Absensi - Dokumentasi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />


        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
                line-height: 1.6;
                color: #333;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .header {
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                margin-bottom: 30px;
                text-align: center;
            }

            .header h1 {
                font-size: 2.5rem;
                color: #667eea;
                margin-bottom: 10px;
                font-weight: 700;
            }

            .header p {
                color: #666;
                font-size: 1.1rem;
            }

            .content {
                background: white;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }

            h2 {
                color: #667eea;
                font-size: 1.8rem;
                margin-top: 30px;
                margin-bottom: 15px;
                padding-bottom: 10px;
                border-bottom: 2px solid #667eea;
                font-weight: 600;
            }

            h3 {
                color: #764ba2;
                font-size: 1.4rem;
                margin-top: 25px;
                margin-bottom: 12px;
                font-weight: 600;
            }

            h4 {
                color: #555;
                font-size: 1.2rem;
                margin-top: 20px;
                margin-bottom: 10px;
                font-weight: 600;
            }

            p, ul, ol {
                margin-bottom: 15px;
            }

            code {
                background: #f4f4f4;
                padding: 2px 6px;
                border-radius: 4px;
                font-family: 'Courier New', monospace;
                font-size: 0.9em;
                color: #e83e8c;
            }

            pre {
                background: #2d2d2d;
                color: #f8f8f2;
                padding: 20px;
                border-radius: 8px;
                overflow-x: auto;
                margin: 15px 0;
                border-left: 4px solid #667eea;
            }

            pre code {
                background: none;
                color: inherit;
                padding: 0;
            }

            .method {
                display: inline-block;
                padding: 4px 12px;
                border-radius: 4px;
                font-weight: 600;
                font-size: 0.85rem;
                margin-right: 8px;
            }

            .method.get {
                background: #28a745;
                color: white;
            }

            .method.post {
                background: #007bff;
                color: white;
            }

            .method.put {
                background: #ffc107;
                color: #333;
            }

            .method.delete {
                background: #dc3545;
                color: white;
            }

            .endpoint {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 6px;
                margin: 15px 0;
                border-left: 4px solid #667eea;
            }

            .endpoint-path {
                font-family: 'Courier New', monospace;
                color: #333;
                font-weight: 600;
            }

            ul {
                padding-left: 25px;
            }

            ul li {
                margin-bottom: 8px;
            }

            .nav-pills {
                position: sticky;
                top: 20px;
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .nav-pills a {
                display: block;
                padding: 10px 15px;
                color: #667eea;
                text-decoration: none;
                border-radius: 6px;
                margin-bottom: 5px;
                transition: all 0.3s;
            }

            .nav-pills a:hover {
                background: #667eea;
                color: white;
            }

            .badge {
                display: inline-block;
                padding: 3px 8px;
                border-radius: 12px;
                font-size: 0.75rem;
                font-weight: 600;
                margin-left: 8px;
            }

            .badge-success {
                background: #28a745;
                color: white;
            }

            .badge-warning {
                background: #ffc107;
                color: #333;
            }

            .badge-danger {
                background: #dc3545;
                color: white;
            }

            .badge-info {
                background: #17a2b8;
                color: white;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin: 15px 0;
            }

            table th,
            table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            table th {
                background: #667eea;
                color: white;
                font-weight: 600;
            }

            table tr:hover {
                background: #f8f9fa;
            }

            .note {
                background: #fff3cd;
                border-left: 4px solid #ffc107;
                padding: 15px;
                margin: 15px 0;
                border-radius: 4px;
            }

            .note strong {
                color: #856404;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>📱 API Absensi Laravel</h1>
                <p>Dokumentasi Lengkap REST API Sistem Absensi Karyawan</p>
            </div>

            <div class="content">
                <h2 id="instalasi">🚀 Instalasi</h2>

                <h3>1. Install Dependencies</h3>
                <pre><code>composer install
composer require laravel/sanctum
composer require barryvdh/laravel-dompdf</code></pre>

                <h3>2. Konfigurasi Environment</h3>
                <p>Copy <code>.env.example</code> ke <code>.env</code> dan sesuaikan konfigurasi database:</p>
                <pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_db
DB_USERNAME=root
DB_PASSWORD=</code></pre>

                <h3>3. Generate Key dan Migrate Database</h3>
                <pre><code>php artisan key:generate
php artisan migrate
php artisan storage:link</code></pre>

                <h2 id="endpoints">📡 API Endpoints</h2>

                <div class="note">
                    <strong>Base URL:</strong> <code>http://localhost:8000/api</code>
                </div>

                <h3>Authentication</h3>

                <h4>1. Register</h4>
                <div class="endpoint">
                    <span class="method post">POST</span>
                    <span class="endpoint-path">/register</span>
                </div>
                <p><strong>Request Body:</strong></p>
                <pre><code>{
    "npk": "EMP001",
    "nama": "John Doe",
    "password": "password123",
    "password_confirmation": "password123",
    "role": "karyawan"
}</code></pre>

                <p><strong>Response:</strong></p>
                <pre><code>{
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
}</code></pre>

                <h4>2. Login</h4>
                <div class="endpoint">
                    <span class="method post">POST</span>
                    <span class="endpoint-path">/login</span>
                </div>
                <p><strong>Request Body:</strong></p>
                <pre><code>{
    "npk": "EMP001",
    "password": "password123"
}</code></pre>

                <h4>3. Logout</h4>
                <div class="endpoint">
                    <span class="method post">POST</span>
                    <span class="endpoint-path">/logout</span>
                </div>
                <p><strong>Headers:</strong></p>
                <pre><code>Authorization: Bearer {token}</code></pre>

                <h3>User Management (CRUD)</h3>

                <div class="note">
                    <strong>⚠️ Headers untuk semua request:</strong>
                    <pre style="margin-top: 10px;"><code>Authorization: Bearer {token}
Content-Type: application/json</code></pre>
                </div>

                <h4>1. Get All Users</h4>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="endpoint-path">/users</span>
                </div>
                <p><strong>Query Parameters:</strong></p>
                <ul>
                    <li><code>role</code> - Filter by role (admin/karyawan)</li>
                    <li><code>search</code> - Search by npk or nama</li>
                    <li><code>per_page</code> - Items per page (default: 15)</li>
                    <li><code>page</code> - Page number</li>
                </ul>
                <p><strong>Example:</strong></p>
                <pre><code>GET /users?role=karyawan&search=John&per_page=10&page=1</code></pre>

                <h4>2. Get User by ID</h4>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="endpoint-path">/users/{id}</span>
                </div>

                <h4>3. Create User</h4>
                <div class="endpoint">
                    <span class="method post">POST</span>
                    <span class="endpoint-path">/users</span>
                </div>
                <p><strong>Request Body:</strong></p>
                <pre><code>{
    "npk": "EMP002",
    "nama": "Jane Smith",
    "password": "password123",
    "role": "admin"
}</code></pre>

                <h4>4. Update User</h4>
                <div class="endpoint">
                    <span class="method put">PUT</span>
                    <span class="endpoint-path">/users/{id}</span>
                </div>
                <p><strong>Request Body:</strong></p>
                <pre><code>{
    "npk": "EMP002",
    "nama": "Jane Smith Updated",
    "role": "karyawan"
}</code></pre>

                <h4>5. Delete User</h4>
                <div class="endpoint">
                    <span class="method delete">DELETE</span>
                    <span class="endpoint-path">/users/{id}</span>
                </div>

                <h3>Absensi Management</h3>

                <h4>1. Clock In</h4>
                <div class="endpoint">
                    <span class="method post">POST</span>
                    <span class="endpoint-path">/absensi/clock-in</span>
                </div>
                <p><strong>Request Body (multipart/form-data):</strong></p>
                <pre><code>user_id: 1
tanggal: 2026-02-06
clock_in_image: [file]
clock_in_lat: -6.200000
clock_in_long: 106.816666</code></pre>

                <p><strong>Response:</strong></p>
                <pre><code>{
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
}</code></pre>

                <h4>2. Clock Out</h4>
                <div class="endpoint">
                    <span class="method post">POST</span>
                    <span class="endpoint-path">/absensi/clock-out/{id}</span>
                </div>
                <p><strong>Request Body (multipart/form-data):</strong></p>
                <pre><code>clock_out_image: [file]
clock_out_lat: -6.200000
clock_out_long: 106.816666</code></pre>

                <h4>3. Get All Absensi with Filters</h4>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="endpoint-path">/absensi</span>
                </div>
                <p><strong>Query Parameters:</strong></p>
                <ul>
                    <li><code>user_id</code> - Filter by user ID</li>
                    <li><code>status</code> - Filter by status (hadir/izin/sakit/terlambat)</li>
                    <li><code>tanggal</code> - Filter by specific date (YYYY-MM-DD)</li>
                    <li><code>start_date</code> - Filter from date</li>
                    <li><code>end_date</code> - Filter to date</li>
                    <li><code>month</code> - Filter by month (1-12)</li>
                    <li><code>year</code> - Filter by year (YYYY)</li>
                    <li><code>search</code> - Search by user name or npk</li>
                    <li><code>order_by</code> - Order by field (default: tanggal)</li>
                    <li><code>order_dir</code> - Order direction (asc/desc, default: desc)</li>
                    <li><code>per_page</code> - Items per page (default: 15)</li>
                </ul>
                <p><strong>Examples:</strong></p>
                <pre><code>GET /absensi?user_id=1&month=2&year=2026
GET /absensi?status=terlambat&start_date=2026-02-01&end_date=2026-02-28
GET /absensi?search=John&per_page=20</code></pre>

                <h4>4. Get Absensi by ID</h4>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="endpoint-path">/absensi/{id}</span>
                </div>

                <h4>5. Update Absensi</h4>
                <div class="endpoint">
                    <span class="method put">PUT</span>
                    <span class="endpoint-path">/absensi/{id}</span>
                </div>
                <p><strong>Request Body:</strong></p>
                <pre><code>{
    "status": "izin",
    "late_duration": 0
}</code></pre>

                <h4>6. Delete Absensi</h4>
                <div class="endpoint">
                    <span class="method delete">DELETE</span>
                    <span class="endpoint-path">/absensi/{id}</span>
                </div>

                <h3>Export Features</h3>

                <h4>1. Export to Excel (CSV)</h4>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="endpoint-path">/absensi/export/excel</span>
                </div>
                <p><strong>Query Parameters (optional - sama dengan Get All Absensi):</strong></p>
                <pre><code>GET /absensi/export/excel?user_id=1&month=2&year=2026</code></pre>
                <p><strong>Response:</strong> Downloads CSV file</p>

                <h4>2. Export to PDF</h4>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="endpoint-path">/absensi/export/pdf</span>
                </div>
                <p><strong>Query Parameters (optional - sama dengan Get All Absensi):</strong></p>
                <pre><code>GET /absensi/export/pdf?status=terlambat&month=2&year=2026</code></pre>
                <p><strong>Response:</strong> Downloads PDF file</p>

                <h3>Statistics</h3>

                <h4>Get User Statistics</h4>
                <div class="endpoint">
                    <span class="method get">GET</span>
                    <span class="endpoint-path">/absensi/user/{userId}/stats</span>
                </div>
                <p><strong>Query Parameters:</strong></p>
                <ul>
                    <li><code>month</code> - Filter by month (1-12)</li>
                    <li><code>year</code> - Filter by year (YYYY)</li>
                </ul>
                <p><strong>Example:</strong></p>
                <pre><code>GET /absensi/user/1/stats?month=2&year=2026</code></pre>

                <p><strong>Response:</strong></p>
                <pre><code>{
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
}</code></pre>

                <h2 id="error">⚠️ Error Handling</h2>

                <p>Semua error response mengikuti format:</p>
                <pre><code>{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["Validation error message"]
    }
}</code></pre>

                <p><strong>Common HTTP Status Codes:</strong></p>
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-success">200</span></td>
                            <td>Success</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-success">201</span></td>
                            <td>Created</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">400</span></td>
                            <td>Bad Request</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">401</span></td>
                            <td>Unauthorized</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">404</span></td>
                            <td>Not Found</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">422</span></td>
                            <td>Validation Error</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-danger">500</span></td>
                            <td>Server Error</td>
                        </tr>
                    </tbody>
                </table>

                <h2 id="notes">📝 Important Notes</h2>

                <h3>Image Upload</h3>
                <ul>
                    <li>Maximum file size: <strong>2MB</strong></li>
                    <li>Accepted formats: <code>jpg</code>, <code>jpeg</code>, <code>png</code>, <code>gif</code></li>
                    <li>Images stored in: <code>storage/app/public/absensi/</code></li>
                </ul>

                <h3>Late Calculation</h3>
                <ul>
                    <li>Work start time: <strong>08:00</strong></li>
                    <li>Late duration calculated in <strong>minutes</strong></li>
                    <li>Status automatically set to "terlambat" if clock in > 08:00</li>
                </ul>

                <h3>Authentication</h3>
                <ul>
                    <li>All endpoints (except register & login) require <strong>Bearer token</strong></li>
                    <li>Token sent in Authorization header: <code>Bearer {token}</code></li>
                </ul>

                <h3>Pagination</h3>
                <ul>
                    <li>Default per_page: <strong>15</strong></li>
                    <li>Response includes <code>links</code> and <code>meta</code> for pagination</li>
                </ul>

                <h3>File Storage</h3>
                <ul>
                    <li>Run <code>php artisan storage:link</code> to create symbolic link</li>
                    <li>Images accessible via <code>/storage/absensi/...</code></li>
                </ul>

                <h2 id="testing">🧪 Testing dengan Postman</h2>

                <h3>1. Setup Environment Variables</h3>
                <p>Buat environment di Postman dengan variables:</p>
                <ul>
                    <li><code>base_url</code>: http://localhost:8000/api</li>
                    <li><code>token</code>: (akan di-set setelah login)</li>
                </ul>

                <h3>2. Testing Flow</h3>
                <ol>
                    <li><strong>Register/Login</strong> - Register user baru atau login, copy token dari response, set sebagai environment variable <code>token</code></li>
                    <li><strong>Test User CRUD</strong> - Create user, Get all users, Update user, Delete user</li>
                    <li><strong>Test Absensi</strong> - Clock in (pagi), Clock out (sore), Get absensi with filters, Update absensi, Get user statistics</li>
                    <li><strong>Test Export</strong> - Export to Excel, Export to PDF</li>
                </ol>

                <div style="margin-top: 30px; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px; text-align: center;">
                    <h3 style="color: white; border: none; margin: 0;">✨ Laravel Absensi API v1.0</h3>
                    <p style="margin-top: 10px; font-size: 0.9rem;">Dokumentasi dibuat dengan ❤️</p>
                </div>
            </div>
        </div>
    </body>
</html>

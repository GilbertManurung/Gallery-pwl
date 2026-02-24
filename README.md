# 📸 Gallery PWL

Aplikasi gallery web dengan fitur authentication, upload file, dan bookmark gambar favorit. Dibangun menggunakan Laravel dengan API berbasis JSON dan PostgreSQL.

## 🛠️ Tech Stack

- **Backend**: PHP 8.4 + Laravel 11 (FrankenPHP Container)
- **Database**: PostgreSQL 17
- **Authentication**: Laravel Sanctum (API Token)
- **API**: RESTful JSON API
- **Frontend**: Blade Templates
- **Orchestration**: Podman Compose
- **Storage**: Local filesystem + S3 compatible

## 📋 Prasyarat

- Podman & Podman Compose
- PHP 8.4+ (jika run local)
- PostgreSQL 17
- Composer
- Node.js & npm (untuk asset compilation)





## 🚀 Quick Start

### 1. Setup Environment

Clone repository dan copy file `.env`:

```bash
cp .env.example .env
```

Edit `.env` dengan konfigurasi:

```env
APP_NAME=Gallery PWL
APP_ENV=local
APP_KEY=base64:xxxxxx
APP_DEBUG=true

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=gallery_pwl
DB_USERNAME=gallery
DB_PASSWORD=secret

VAL_KEY=fb1e2ba51271e48e46bab82b294eee513e0336f361ace960fb1722f69ba70347
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Jalankan Aplikasi dengan Docker

```bash
podman-compose up -d
```

Container yang akan berjalan:
- `gallery-pwl-app`: FrankenPHP + Laravel (port 8765)
- `gallery-pwl-db`: PostgreSQL (port 5432)
- `gallery-pwl-caddy`: Reverse Proxy (port 80, 443)

### 4. Database Setup

Masuk ke container dan jalankan migration:

```bash
podman exec -it gallery-pwl-app bash
php artisan migrate --seed
```

Cek status migration:

```bash
php artisan migrate:status
```

### 5. Buka Aplikasi

```
http://localhost:8765
```

---

## 📁 Struktur Project

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Route controllers
│   │   └── Middleware/       # Custom middleware
│   ├── Models/
│   │   ├── User.php
│   │   ├── Upload.php        # Model upload file
│   │   └── UserImageFavorite.php  # Model bookmark gambar
│   └── Services/
│       └── StorageService.php # Service untuk storage file
├── database/
│   ├── migrations/           # Schema database
│   └── seeders/              # Data seeding
├── routes/
│   ├── web.php              # Web routes
│   └── api.php              # API routes
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Stylesheet
│   └── js/                  # JavaScript
├── storage/
│   ├── app/private/         # Private files
│   └── app/public/          # Public files
└── tests/                   # Unit & feature tests
```

---

## 🔐 Authentication & API

### VAL_KEY Middleware

Semua API request **WAJIB** menyertakan header `VAL_KEY`:

```bash
curl -H "VAL_KEY: fb1e2ba51271e48e46bab82b294eee513e0336f361ace960fb1722f69ba70347" \
  http://localhost:8765/api/...
```

### Sanctum Token

Token user disimpan di database (personal_access_tokens) untuk autentikasi akses ke protected routes.

---

## 📡 API Endpoints

### Authentication

```
POST /api/auth/register
POST /api/auth/login
GET /api/auth/logout
```

### Profile

```
GET /api/profile              # Requires auth token
PUT /api/profile              # Requires auth token
```

### Upload Gambar

```
POST /api/uploads             # Upload file
GET /api/uploads              # List uploads
GET /api/uploads/{id}         # Detail upload
DELETE /api/uploads/{id}      # Delete upload
```

### Favorites

```
POST /api/favorites                    # Add to favorites
GET /api/favorites                     # List favorites
DELETE /api/favorites/{uploadId}       # Remove from favorites
```

---

## 🗄️ Database Schema

### Users Table

```sql
id, name, email, email_verified_at, password, remember_token, created_at, updated_at
```

### Uploads Table

```sql
id, user_id, filename, original_name, mime_type, size, path, created_at, updated_at
```

### UserImageFavorites Table

```sql
id, user_id, upload_id, created_at, updated_at
```

### Personal Access Tokens Table (Sanctum)


```sql
id, tokenable_type, tokenable_id, name, token, abilities, last_used_at, created_at, updated_at
```

---

## 🧪 Testing API

### Contoh: Register User

```bash
curl -X POST http://localhost:8765/api/auth/register \
  -H "Content-Type: application/json" \
  -H "VAL_KEY: fb1e2ba51271e48e46bab82b294eee513e0336f361ace960fb1722f69ba70347" \
  -d '{
    "name": "Gilbert",
    "email": "gilbert@example.com",
    "password": "password123"
  }'
```

**Response Success (201)**:

```json
{
  "status": "success",
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "Gilbert",
    "email": "gilbert@example.com"
  },
  "token": "1|XXXXXXXXXXXX"
}
```

### Contoh: Login

```bash
curl -X POST http://localhost:8765/api/auth/login \
  -H "Content-Type: application/json" \
  -H "VAL_KEY: fb1e2ba51271e48e46bab82b294eee513e0336f361ace960fb1722f69ba70347" \
  -d '{
    "email": "gilbert@example.com",
    "password": "password123"
  }'
```

### Contoh: Access Protected Route

```bash
curl -X GET http://localhost:8765/api/profile \
  -H "VAL_KEY: fb1e2ba51271e48e46bab82b294eee513e0336f361ace960fb1722f69ba70347" \
  -H "Authorization: Bearer 1|XXXXXXXXXXXX"
```

---

## 🛠️ Perintah Penting

### Laravel Artisan

```bash
# Database
php artisan migrate                    # Run migrations
php artisan migrate:status             # Check migration status
php artisan migrate --seed             # Migrate + seed
php artisan db:seed                    # Run seeders
php artisan migrate:fresh --seed       # Reset database

# Routing
php artisan route:list                 # List all routes
php artisan route:list | grep api      # Filter API routes

# Cache
php artisan cache:clear                # Clear application cache
php artisan config:cache               # Cache configuration

# Tinker (REPL)
php artisan tinker                     # Interactive shell

# Queue
php artisan queue:work                 # Start queue worker
php artisan queue:failed               # List failed jobs
```

### Podman

```bash
# Container management
podman-compose up -d                   # Start all containers
podman-compose down                    # Stop all containers
podman-compose logs -f gallery-pwl-app # View app logs

# Access container
podman exec -it gallery-pwl-app bash   # SSH into app container
podman exec -it gallery-pwl-db psql -U gallery -d gallery_pwl

# Restart service
podman restart gallery-pwl-app         # Restart app after code changes
```

---

## 🐛 Troubleshooting

### Database Connection Error

```bash
# Cek status container
podman-compose ps

# Cek database logs
podman-compose logs gallery-pwl-db

# Cek env variables
cat .env | grep DB_
```

### Routes not found (404)

```bash
# Restart container setelah edit routes
podman restart gallery-pwl-app

# Verify routes
php artisan route:list
```

### Permission Denied on Storage

```bash
# Fix storage permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### VAL_KEY validation fails

```bash
# Pastikan VAL_KEY di request header sesuai dengan .env
cat .env | grep VAL_KEY
```

---

## 📝 Development Workflow

### 1. Edit Code

Ubah file di dalam project (Laravel akan auto-reload dalam dev mode)

### 2. Database Changes

Jika ada schema baru:

```bash
php artisan make:migration create_table_name
php artisan migrate
```

### 3. Routes/Controllers

Jika edit routes atau middleware:

```bash
podman restart gallery-pwl-app
```

### 4. Assets (CSS/JS)

```bash
npm run dev      # Development with watch
npm run build    # Production build
```

---

## 🔒 Security Notes

- ✅ Gunakan `.env.example` untuk public, `.env` private (jangan commit)
- ✅ Jangan hardcode secrets di code
- ✅ VAL_KEY hanya untuk validasi global, bukan user authentication
- ✅ Password user di-hash menggunakan bcrypt
- ✅ Token Sanctum disimpan HASH di database
- ✅ Enable HTTPS di production (Caddy sudah support)

---

## 📚 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [PostgreSQL Docs](https://www.postgresql.org/docs/)
- [Podman Documentation](https://docs.podman.io/)

---

## 👤 Author

Gilbert | gallery-pwl project

## 📄 License

This project is licensed under the MIT License.




gilbert@ASUS:~/projects/gallery-pwl$ podman stop 8e1561db6401
8e1561db6401
gilbert@ASUS:~/projects/gallery-pwl$ podman stop 23148536899f
23148536899f
gilbert@ASUS:~/projects/gallery-pwl$ podman stop  7b844bd99fbb
7b844bd99fbb



gilbert@ASUS:~/projects/gallery-pwl$ podman ps
CONTAINER ID  IMAGE                             COMMAND               CREATED                 STATUS             PORTS                             NAMES
7b844bd99fbb  docker.io/library/postgres:17     postgres              Less than a second ago  Up About a minute  0.0.0.0:55432->5432/tcp           gallery-pwl-db
8e1561db6401  docker.io/minio/minio:latest      server /data --co...  Less than a second ago  Up 39 seconds      0.0.0.0:9900-9901->9000-9001/tcp  minio
23148536899f  localhost/gallery-pwl_app:latest  frankenphp run --...  Less than a second ago  Up 39 seconds      0.0.0.0:8765->8765/tcp            gallery-pwl-app

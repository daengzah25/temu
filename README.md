# TEMU - Platform UMKM

Platform untuk membantu UMKM dalam mengelola produk, promosi, dan interaksi dengan pelanggan. Dilengkapi dengan fitur AI untuk generate konten promosi otomatis.

## Fitur Utama

- 🔐 **Autentikasi Google OAuth** - Login menggunakan akun Google
- 🏢 **Manajemen UMKM** - Registrasi dan pengelolaan profil UMKM dengan sistem approval
- 📦 **Manajemen Produk** - Upload produk dengan multiple gambar menggunakan Cloudinary
- 🤖 **AI Promotion Generator** - Generate konten promosi untuk Instagram, WhatsApp, dan Facebook menggunakan HuggingFace AI
- 👥 **Role Management** - Sistem role untuk Admin, UMKM, dan Visitor
- 🔖 **Bookmark** - Visitor dapat bookmark UMKM favorit
- 📍 **Nearby Search** - Pencarian UMKM berdasarkan lokasi

## Requirements

Sebelum memulai, pastikan sistem Anda memiliki:

- **PHP** >= 8.2
- **Composer** (dependency manager untuk PHP)
- **Node.js** >= 18.x dan **npm**
- **Database** (SQLite, MySQL, atau PostgreSQL)
- **Extension PHP** yang diperlukan:
  - BCMath
  - Ctype
  - cURL
  - DOM
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PCRE
  - PDO
  - Tokenizer
  - XML

## Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd temu
```

### 2. Install Dependencies

**Install PHP Dependencies:**
```bash
composer install
```

**Install Node.js Dependencies:**
```bash
npm install
```

### 3. Setup Environment Variables

Copy file `.env.example` menjadi `.env` (jika belum ada):

```bash
cp .env.example .env
```

Atau buat file `.env` baru dan konfigurasi sesuai kebutuhan.

## Konfigurasi .env

File `.env` berisi semua konfigurasi yang diperlukan untuk menjalankan aplikasi. Berikut adalah penjelasan lengkap untuk setiap variabel:

### Application Configuration

```env
APP_NAME="TEMU"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=UTC
```

- **APP_NAME**: Nama aplikasi
- **APP_ENV**: Environment aplikasi (`local`, `staging`, `production`)
- **APP_KEY**: Application key (generate dengan `php artisan key:generate`)
- **APP_DEBUG**: Mode debug (`true` untuk development, `false` untuk production)
- **APP_URL**: URL aplikasi Anda
- **APP_TIMEZONE**: Timezone aplikasi (default: UTC)

### Database Configuration

**Untuk SQLite (Default):**
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

**Untuk MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=temu_db
DB_USERNAME=root
DB_PASSWORD=
```

**Untuk PostgreSQL:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=temu_db
DB_USERNAME=postgres
DB_PASSWORD=
```

**Catatan:** Untuk SQLite, pastikan file database ada di `database/database.sqlite` atau sesuaikan path di `DB_DATABASE`.

### Cloudinary Configuration

Cloudinary digunakan untuk menyimpan dan mengelola gambar produk.

```env
CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
CLOUDINARY_UPLOAD_PRESET=your_upload_preset
CLOUDINARY_NOTIFICATION_URL=
CLOUDINARY_UPLOAD_ROUTE=
CLOUDINARY_UPLOAD_ACTION=
```

**Cara mendapatkan Cloudinary URL:**
1. Daftar di [Cloudinary](https://cloudinary.com/)
2. Dari dashboard, copy `Cloudinary URL` yang berformat: `cloudinary://api_key:api_secret@cloud_name`
3. Paste ke `CLOUDINARY_URL`
4. (Optional) Buat upload preset di dashboard dan masukkan ke `CLOUDINARY_UPLOAD_PRESET`

### Google OAuth Configuration

Untuk autentikasi menggunakan Google:

```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**Cara setup Google OAuth:**
1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang ada
3. Enable Google+ API
4. Buat OAuth 2.0 Client ID
5. Set Authorized redirect URIs: `http://localhost:8000/auth/google/callback` (untuk production, ganti dengan domain Anda)
6. Copy Client ID dan Client Secret ke `.env`

### HuggingFace AI Configuration

Untuk fitur AI Promotion Generator:

```env
HUGGINGFACE_API_TOKEN=your_huggingface_token
HUGGINGFACE_MODEL=meta-llama/Llama-3.2-3B-Instruct
```

**Cara mendapatkan HuggingFace Token:**
1. Daftar di [HuggingFace](https://huggingface.co/)
2. Buka Settings > Access Tokens
3. Buat token baru dengan permission `read`
4. Copy token ke `HUGGINGFACE_API_TOKEN`
5. (Optional) Ganti `HUGGINGFACE_MODEL` dengan model lain yang tersedia

### Mail Configuration

Konfigurasi email untuk notifikasi (optional untuk development):

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Untuk development**, gunakan `MAIL_MAILER=log` (email akan disimpan di `storage/logs/laravel.log`).

**Untuk production**, konfigurasi SMTP atau service email lainnya:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

### Queue Configuration

```env
QUEUE_CONNECTION=database
```

- **sync**: Menjalankan job secara synchronous (tidak perlu queue worker)
- **database**: Menggunakan database sebagai queue driver (perlu menjalankan `php artisan queue:work`)

### Session & Cache Configuration

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_STORE=database
```

### Redis Configuration (Optional)

Jika menggunakan Redis untuk cache atau queue:

```env
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=0
REDIS_CACHE_DB=1
```

## Setup Database

### 1. Generate Application Key

```bash
php artisan key:generate
```

### 2. Buat Database (jika menggunakan MySQL/PostgreSQL)

**MySQL:**
```bash
mysql -u root -p
CREATE DATABASE temu_db;
```

**PostgreSQL:**
```bash
psql -U postgres
CREATE DATABASE temu_db;
```

**SQLite:**
File database akan dibuat otomatis saat migration dijalankan.

### 3. Jalankan Migrations

```bash
php artisan migrate
```

### 4. (Optional) Jalankan Seeders

```bash
php artisan db:seed
```

## Cara Menjalankan Sistem

### Development Mode (Recommended)

Jalankan semua service sekaligus menggunakan script yang sudah disediakan:

```bash
composer dev
```

Script ini akan menjalankan:
- **Laravel Server** di `http://localhost:8000`
- **Queue Worker** untuk memproses background jobs
- **Laravel Pail** untuk melihat logs real-time
- **Vite Dev Server** untuk hot-reload assets

Akses aplikasi di browser: `http://localhost:8000`

### Manual (Menjalankan Secara Terpisah)

Jika ingin menjalankan setiap service secara terpisah, buka terminal terpisah untuk masing-masing:

**Terminal 1 - Laravel Server:**
```bash
php artisan serve
```

**Terminal 2 - Queue Worker:**
```bash
php artisan queue:listen
```

**Terminal 3 - Vite Dev Server:**
```bash
npm run dev
```

**Terminal 4 - Logs (Optional):**
```bash
php artisan pail
```

### Production Mode

**1. Build Assets:**
```bash
npm run build
```

**2. Optimize Application:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**3. Set Environment:**
Pastikan di `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

**4. Jalankan Server:**
Gunakan web server seperti Nginx atau Apache, atau gunakan:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

**5. Jalankan Queue Worker (jika menggunakan queue):**
```bash
php artisan queue:work --daemon
```

Atau gunakan process manager seperti Supervisor untuk menjalankan queue worker secara otomatis.

## Struktur Proyek

```
temu/
├── app/
│   ├── Http/Controllers/     # Controller aplikasi
│   ├── Models/               # Eloquent models
│   ├── Services/             # Business logic services
│   └── Notifications/        # Email notifications
├── config/                   # Konfigurasi aplikasi
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/                   # Public assets
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # CSS files
│   └── js/                   # JavaScript files
├── routes/                   # Route definitions
└── storage/                  # Storage files
```

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Build Tool**: Vite
- **Database**: SQLite (default), MySQL, PostgreSQL
- **Image Storage**: Cloudinary
- **Authentication**: Laravel Socialite (Google OAuth)
- **AI Service**: HuggingFace API
- **Queue**: Laravel Queue (Database driver)

## Troubleshooting

### Error: "No application encryption key has been specified"

Jalankan:
```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [14] unable to open database file" (SQLite)

Pastikan:
1. File `database/database.sqlite` sudah ada
2. Folder `database/` memiliki permission write
3. Path di `DB_DATABASE` benar

**Buat file database:**
```bash
touch database/database.sqlite
```

### Error: "Class 'PDO' not found"

Install PHP PDO extension:
```bash
# Ubuntu/Debian
sudo apt-get install php-pdo php-pdo-mysql

# macOS (Homebrew)
brew install php@8.2
```

### Vite assets tidak loading

Pastikan Vite dev server berjalan:
```bash
npm run dev
```

Atau build assets untuk production:
```bash
npm run build
```

### Queue jobs tidak diproses

Pastikan queue worker berjalan:
```bash
php artisan queue:work
```

Atau jika menggunakan database queue, pastikan table `jobs` sudah dibuat:
```bash
php artisan queue:table
php artisan migrate
```

### Cloudinary upload error

Pastikan:
1. `CLOUDINARY_URL` sudah dikonfigurasi dengan benar
2. Format URL: `cloudinary://api_key:api_secret@cloud_name`
3. API key dan secret valid

### Google OAuth error

Pastikan:
1. `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` sudah benar
2. `GOOGLE_REDIRECT_URI` sesuai dengan yang didaftarkan di Google Cloud Console
3. Google+ API sudah di-enable di Google Cloud Console

### HuggingFace API error

Pastikan:
1. `HUGGINGFACE_API_TOKEN` valid
2. Model yang digunakan (`HUGGINGFACE_MODEL`) tersedia dan accessible
3. Token memiliki permission `read`

## Kontribusi

Silakan buat issue atau pull request jika ingin berkontribusi pada proyek ini.

## License

MIT License

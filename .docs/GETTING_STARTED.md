# 🚀 Panduan Memulai PADRP ASSYUKRO

Dokumen ini berisi panduan lengkap untuk menjalankan aplikasi dan mengelola database.

---

## 📋 Daftar Isi

1. [Menjalankan Aplikasi](#-menjalankan-aplikasi)
2. [Mengakses Database MySQL](#-mengakses-database-mysql)
3. [Perintah Artisan Berguna](#-perintah-artisan-berguna)
4. [Akun Default untuk Testing](#-akun-default-untuk-testing)
5. [Troubleshooting](#-troubleshooting)

---

## 🏃 Menjalankan Aplikasi

### Persiapan Awal (Hanya Sekali)

```bash
# 1. Masuk ke folder project
cd /Users/mac/FREELANCE/pdarp-assyukro

# 2. Install dependencies PHP (jika belum)
composer install

# 3. Install dependencies JavaScript (jika belum)
npm install

# 4. Copy file environment (jika belum ada .env)
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Jalankan migration dan seeder
php artisan migrate:fresh --seed
```

### Menjalankan Server Development

Ada **2 cara** untuk menjalankan aplikasi:

#### Cara 1: Menjalankan Terpisah (Rekomendasi untuk Development)

Buka **2 terminal** berbeda:

**Terminal 1 - Laravel Server:**

```bash
cd /Users/mac/FREELANCE/pdarp-assyukro
php artisan serve
```

Server akan berjalan di: `http://127.0.0.1:8000`

**Terminal 2 - Vite (Hot Reload CSS/JS):**

```bash
cd /Users/mac/FREELANCE/pdarp-assyukro
npm run dev
```

#### Cara 2: Menggunakan Composer Script

```bash
cd /Users/mac/FREELANCE/pdarp-assyukro
composer run dev
```

> ⚠️ **Catatan:** Cara ini menjalankan Vite saja. Anda tetap perlu menjalankan `php artisan serve` di terminal lain.

### Menghentikan Server

Tekan `Ctrl + C` di terminal yang menjalankan server.

---

## 🗄️ Mengakses Database MySQL

### Mengelola MySQL Service

MySQL berjalan sebagai background service. Gunakan perintah berikut untuk mengelolanya:

```bash
# Menyalakan MySQL
brew services start mysql

# Mematikan MySQL
brew services stop mysql

# Restart MySQL
brew services restart mysql

# Cek status semua services
brew services list
```

> ⚠️ **Penting:** MySQL harus dalam keadaan **started** agar aplikasi bisa berjalan!

### Informasi Koneksi Database

| Parameter    | Nilai            |
| ------------ | ---------------- |
| **Database** | `padrp_assyukro` |
| **Host**     | `127.0.0.1`      |
| **Port**     | `3306`           |
| **Username** | `root`           |
| **Password** | _(kosong)_       |

### Cara 1: Via Terminal (MySQL CLI)

```bash
# Login ke MySQL
mysql -u root

# Pilih database
USE padrp_assyukro;

# Lihat semua tabel
SHOW TABLES;

# Lihat data users
SELECT * FROM users;

# Lihat data categories (kategori keuangan)
SELECT * FROM categories;

# Lihat data transactions
SELECT * FROM transactions;

# Lihat data events
SELECT * FROM events;

# Keluar dari MySQL
EXIT;
```

### Cara 2: Via Laravel Tinker (Rekomendasi)

Laravel Tinker adalah REPL interaktif untuk berinteraksi dengan aplikasi.

```bash
cd /Users/mac/FREELANCE/pdarp-assyukro
php artisan tinker
```

**Contoh Query dengan Tinker:**

```php
# Lihat semua users
User::all();

# Lihat user admin
User::where('role', 'admin')->first();

# Lihat users pending
User::where('status', 'pending')->get();

# Lihat semua kategori keuangan
Category::all();

# Lihat saldo per kategori
Category::all()->map(fn($c) => [$c->name => $c->formatted_balance]);

# Lihat total saldo
Category::getTotalBalance();

# Lihat semua events
Event::all();

# Lihat events yang akan datang
Event::upcoming()->get();

# Keluar dari Tinker
exit
```

### Cara 3: Menggunakan GUI Database Client

Anda bisa menggunakan aplikasi GUI untuk melihat database dengan lebih mudah:

#### TablePlus (Gratis/Berbayar)

1. Download dari: https://tableplus.com
2. Buat koneksi baru → MySQL
3. Masukkan informasi koneksi di atas
4. Klik Connect

#### Sequel Pro / Sequel Ace (Gratis - Mac Only)

1. Download Sequel Ace dari App Store
2. Buat koneksi baru
3. Masukkan informasi koneksi di atas
4. Klik Connect

#### DBeaver (Gratis - Cross Platform)

1. Download dari: https://dbeaver.io
2. Buat koneksi baru → MySQL
3. Masukkan informasi koneksi di atas
4. Klik Test Connection → Finish

#### phpMyAdmin (Via Web Browser)

```bash
# Install phpMyAdmin via Homebrew
brew install phpmyadmin

# Jalankan PHP built-in server untuk phpMyAdmin
cd /opt/homebrew/share/phpmyadmin
php -S localhost:8080
```

Buka di browser: `http://localhost:8080`

---

## 🔧 Perintah Artisan Berguna

### Database

```bash
# Jalankan migration
php artisan migrate

# Reset database dan jalankan migration + seeder
php artisan migrate:fresh --seed

# Rollback migration terakhir
php artisan migrate:rollback

# Lihat status migration
php artisan migrate:status

# Jalankan seeder saja
php artisan db:seed
```

### Cache & Optimization

```bash
# Bersihkan semua cache
php artisan optimize:clear

# Bersihkan cache config
php artisan config:clear

# Bersihkan cache view
php artisan view:clear

# Bersihkan cache route
php artisan route:clear
```

### Debugging

```bash
# Lihat semua routes
php artisan route:list

# Lihat routes dengan filter
php artisan route:list --path=admin

# Masuk ke mode maintenance
php artisan down

# Keluar dari mode maintenance
php artisan up
```

### Generate Files

```bash
# Buat controller baru
php artisan make:controller NamaController

# Buat model dengan migration
php artisan make:model NamaModel -m

# Buat seeder
php artisan make:seeder NamaSeeder

# Buat middleware
php artisan make:middleware NamaMiddleware
```

---

## 👤 Akun Default untuk Testing

Setelah menjalankan `php artisan migrate:fresh --seed`, data sample lengkap akan tersedia:

### Akun Login

| Role        | Email               | Password      | Status               |
| ----------- | ------------------- | ------------- | -------------------- |
| **Admin**   | `admin@gmail.com`   | `password123` | Aktif ✓              |
| **Anggota** | `anggota@gmail.com` | `password123` | Aktif ✓              |
| **Pending** | `pending@gmail.com` | `password123` | Menunggu Approval ⏳ |

### Data Sample yang Tersedia

Aplikasi sudah dilengkapi dengan data sample yang lengkap untuk pengujian:

1. **Anggota (17 orang)**

    - 1 Admin
    - 11 Anggota Aktif (termasuk `anggota@gmail.com`)
    - 4 Anggota Pending (termasuk `pending@gmail.com`)
    - 1 Anggota Non-Aktif

2. **Kategori Keuangan (4 kategori)**

    - 💰 Kas Assyukro
    - 📆 Rutinan Mingguan
    - 📅 Rutinan Bulanan
    - 🌙 Keuangan Idul Fitri

3. **Transaksi Keuangan (30+ transaksi)**

    - Transaksi pemasukan dan pengeluaran untuk setiap kategori
    - Data dari bulan Januari - Maret 2025

4. **Kegiatan/Events (10 kegiatan)**
    - 4 Kegiatan Selesai (masa lalu)
    - 6 Kegiatan Mendatang (masa depan)
    - Termasuk pengajian, bakti sosial, olahraga, dll

> 💡 **Tip:** Semua anggota tambahan menggunakan password yang sama: `password123`

### URL Penting

| Halaman          | URL                                    |
| ---------------- | -------------------------------------- |
| Landing Page     | http://127.0.0.1:8000                  |
| Login            | http://127.0.0.1:8000/login            |
| Register         | http://127.0.0.1:8000/register         |
| Admin Dashboard  | http://127.0.0.1:8000/admin/dashboard  |
| Member Dashboard | http://127.0.0.1:8000/member/dashboard |

---

## 🔥 Troubleshooting

### Error: "Unable to locate a class or view for component"

```bash
php artisan view:clear
php artisan config:clear
```

### Error: "SQLSTATE[HY000]: Connection refused"

Pastikan MySQL sudah berjalan:

```bash
brew services start mysql
```

### Error: "Vite manifest not found"

Build ulang assets:

```bash
npm run build
```

### Error: "Class not found"

```bash
composer dump-autoload
```

### Reset Semua (Nuclear Option)

```bash
# Hapus semua cache dan reset database
php artisan optimize:clear
php artisan migrate:fresh --seed
npm run build
```

---

## 📁 Struktur Folder Penting

```
pdarp-assyukro/
├── app/
│   ├── Enums/          # PHP Enums (UserRole, UserStatus, dll)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/  # Controllers untuk admin
│   │   │   ├── Auth/   # Authentication controller
│   │   │   └── Member/ # Controllers untuk member
│   │   └── Middleware/ # Custom middleware
│   └── Models/         # Eloquent models
├── database/
│   ├── migrations/     # Database migrations
│   └── seeders/        # Database seeders
├── resources/
│   ├── css/           # Tailwind CSS
│   └── views/         # Blade templates
├── routes/
│   └── web.php        # Web routes
└── .docs/             # Dokumentasi project
```

---

## 💡 Tips Development

1. **Selalu jalankan `npm run dev`** saat mengubah CSS/JS untuk hot reload
2. **Gunakan `php artisan tinker`** untuk testing query cepat
3. **Cek `storage/logs/laravel.log`** jika ada error
4. **Gunakan browser DevTools** (F12) untuk debug frontend

---

_Dokumentasi ini dibuat pada: 25 Desember 2024_

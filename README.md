# 🏛️ PADRP ASSYUKRO - Sistem Manajemen Organisasi

**Platform digital untuk mengelola organisasi Persatuan Anak Daerah, Pesantren, dan Rantau (PADRP) ASSYUKRO secara transparan, modern, dan efisien.**

![Laravel](https://img.shields.io/badge/Laravel-12-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4-06B6D4?style=flat-square&logo=tailwindcss)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square&logo=mysql)

---

## 📋 Daftar Isi

1. [Pendahuluan](#-pendahuluan)
2. [Fitur Utama](#-fitur-utama)
3. [Persyaratan Sistem](#-persyaratan-sistem)
4. [Panduan Instalasi](#-panduan-instalasi)
5. [Konfigurasi](#-konfigurasi)
6. [Menjalankan Aplikasi](#-menjalankan-aplikasi)
7. [Akun Default](#-akun-default)
8. [Struktur Folder](#-struktur-folder)
9. [Troubleshooting](#-troubleshooting)
10. [Kontak Developer](#-kontak-developer)

---

## 📖 Pendahuluan

PADRP ASSYUKRO adalah aplikasi web berbasis Laravel yang dirancang untuk membantu pengelolaan organisasi PADRP ASSYUKRO. Aplikasi ini menyediakan fitur manajemen anggota, keuangan, dan kegiatan organisasi dengan antarmuka yang modern dan responsif.

---

## ✨ Fitur Utama

### 👤 Manajemen Pengguna

- **Multi-role**: Admin dan Anggota dengan hak akses berbeda
- **Pendaftaran Online**: Calon anggota dapat mendaftar melalui website
- **Persetujuan Keanggotaan**: Admin dapat menyetujui atau menolak pendaftaran
- **Profil Lengkap**: Data anggota termasuk foto, alamat, dan informasi kontak

### 💰 Manajemen Keuangan

- **Multi-kategori**: Kas Assyukro, Rutinan Mingguan, Rutinan Bulanan, Keuangan Idul Fitri
- **Pemasukan & Pengeluaran**: Pencatatan transaksi keuangan lengkap
- **Laporan Transparan**: Anggota dapat melihat laporan keuangan organisasi
- **Format Rupiah**: Tampilan nominal dengan format Indonesia (titik sebagai pemisah ribuan)

### 📅 Manajemen Kegiatan

- **Jadwal Kegiatan**: Pembuatan dan pengelolaan agenda organisasi
- **Status Kegiatan**: Akan Datang, Sedang Berlangsung, Selesai
- **Filter & Pencarian**: Kemudahan mencari kegiatan berdasarkan status

### 📊 Dashboard

- **Statistik Real-time**: Jumlah anggota, kegiatan, dan keuangan
- **Grafik Visual**: Visualisasi data keuangan
- **Aktivitas Terbaru**: Log aktivitas terkini

---

## 💻 Persyaratan Sistem

Sebelum menginstal, pastikan komputer Anda memenuhi persyaratan berikut:

### Software yang Diperlukan

| Software | Versi Minimum         | Download                                             |
| -------- | --------------------- | ---------------------------------------------------- |
| PHP      | 8.2 atau lebih tinggi | [php.net](https://www.php.net/downloads)             |
| Composer | 2.0+                  | [getcomposer.org](https://getcomposer.org/download/) |
| Node.js  | 18.0+                 | [nodejs.org](https://nodejs.org/)                    |
| MySQL    | 8.0+                  | [mysql.com](https://dev.mysql.com/downloads/)        |
| Git      | Terbaru               | [git-scm.com](https://git-scm.com/downloads)         |

### Ekstensi PHP yang Diperlukan

- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- PDO_MySQL
- Tokenizer
- XML

### Cara Cek Versi

```bash
# Cek versi PHP
php -v

# Cek versi Composer
composer -V

# Cek versi Node.js
node -v

# Cek versi npm
npm -v

# Cek versi MySQL
mysql --version

# Cek versi Git
git --version
```

---

## 🚀 Panduan Instalasi

### Langkah 1: Clone Repository

```bash
# Clone repository dari GitHub
git clone https://github.com/RanggaDwi16/web-assyukro.git

# Masuk ke direktori project
cd web-assyukro
```

### Langkah 2: Install Dependencies PHP

```bash
# Install dependencies menggunakan Composer
composer install
```

> ⏳ **Catatan**: Proses ini membutuhkan waktu beberapa menit tergantung koneksi internet.

### Langkah 3: Install Dependencies JavaScript

```bash
# Install dependencies menggunakan npm
npm install
```

### Langkah 4: Buat File Environment

```bash
# Copy file .env.example menjadi .env
cp .env.example .env
```

### Langkah 5: Generate Application Key

```bash
# Generate unique application key
php artisan key:generate
```

### Langkah 6: Buat Database

Buat database MySQL baru dengan nama `pdarp_assyukro` (atau nama lain sesuai keinginan):

**Menggunakan Terminal/Command Line:**

```bash
# Login ke MySQL
mysql -u root -p

# Buat database baru
CREATE DATABASE pdarp_assyukro;

# Keluar dari MySQL
exit;
```

**Atau menggunakan phpMyAdmin:**

1. Buka phpMyAdmin di browser (biasanya http://localhost/phpmyadmin)
2. Klik "New" di sidebar kiri
3. Masukkan nama database: `pdarp_assyukro`
4. Klik "Create"

### Langkah 7: Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pdarp_assyukro
DB_USERNAME=root
DB_PASSWORD=password_mysql_anda
```

> ⚠️ **Penting**: Ganti `password_mysql_anda` dengan password MySQL Anda yang sebenarnya.

### Langkah 8: Jalankan Migrasi dan Seeder

```bash
# Jalankan migrasi database dan seeder untuk data dummy
php artisan migrate:fresh --seed
```

> ✅ Perintah ini akan membuat semua tabel dan mengisi data contoh.

### Langkah 9: Build Assets Frontend

```bash
# Build CSS dan JavaScript untuk production
npm run build
```

---

## ⚙️ Konfigurasi

### Konfigurasi File .env

Berikut adalah konfigurasi penting dalam file `.env`:

```env
# Nama Aplikasi
APP_NAME="PADRP ASSYUKRO"

# Environment (local untuk development, production untuk live)
APP_ENV=local

# Debug Mode (true untuk development, false untuk production)
APP_DEBUG=true

# URL Aplikasi
APP_URL=http://localhost:8000

# Konfigurasi Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pdarp_assyukro
DB_USERNAME=root
DB_PASSWORD=

# Timezone (Indonesia)
APP_TIMEZONE=Asia/Jakarta
```

### Konfigurasi untuk Production

Jika akan di-deploy ke server production, ubah:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com
```

---

## ▶️ Menjalankan Aplikasi

### Development Server

```bash
# Jalankan server development Laravel
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

### Menjalankan dengan Port Berbeda

```bash
# Jika port 8000 sudah digunakan
php artisan serve --port=8080
```

### Mode Development (dengan Hot Reload)

Untuk development dengan hot reload CSS/JS:

```bash
# Terminal 1: Jalankan Laravel server
php artisan serve

# Terminal 2: Jalankan Vite dev server (opsional, untuk hot reload)
npm run dev
```

---

## 👥 Akun Default

Setelah menjalankan seeder, tersedia akun-akun berikut:

### 🔐 Akun Admin

| Field    | Value             |
| -------- | ----------------- |
| Email    | `admin@gmail.com` |
| Password | `password123`     |
| Role     | Administrator     |

### 🔐 Akun Demo Anggota

| Email                      | Password      | Status               |
| -------------------------- | ------------- | -------------------- |
| `rangga@gmail.com`         | `password123` | Aktif                |
| `anggota@gmail.com`        | `password123` | Aktif                |
| `ahmad.fauzi@gmail.com`    | `password123` | Aktif                |
| `siti.rahmawati@gmail.com` | `password123` | Aktif                |
| `pending@gmail.com`        | `password123` | Menunggu Persetujuan |

> 💡 **Tips**: Gunakan akun admin untuk mengelola aplikasi, dan akun anggota untuk melihat tampilan dari sisi member.

---

## 📁 Struktur Folder

```
pdarp-assyukro/
├── app/                    # Logika aplikasi
│   ├── Enums/              # Enum classes (Gender, Role, Status, dll)
│   ├── Http/
│   │   ├── Controllers/    # Controller (Admin & Member)
│   │   └── Middleware/     # Middleware
│   ├── Models/             # Eloquent Models
│   └── Services/           # Service classes
├── bootstrap/              # Bootstrap & cache
├── config/                 # Konfigurasi aplikasi
├── database/
│   ├── migrations/         # File migrasi database
│   └── seeders/            # Data seeder
├── public/                 # File publik (CSS, JS, images)
│   ├── build/              # Compiled assets
│   └── images/             # Gambar (termasuk logo)
├── resources/
│   ├── css/                # Source CSS
│   ├── js/                 # Source JavaScript
│   └── views/              # Blade templates
│       ├── admin/          # Views untuk admin
│       ├── auth/           # Views untuk autentikasi
│       ├── components/     # Reusable components
│       └── member/         # Views untuk member
├── routes/
│   └── web.php             # Route definitions
├── storage/                # File storage
├── .env                    # Environment configuration
├── composer.json           # PHP dependencies
├── package.json            # Node.js dependencies
└── vite.config.js          # Vite configuration
```

---

## 🔧 Troubleshooting

### Error: "Class not found"

```bash
# Regenerate autoload
composer dump-autoload

# Clear all cache
php artisan optimize:clear
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"

Pastikan MySQL server sudah berjalan:

**Windows:**

- Buka XAMPP Control Panel dan start MySQL

**macOS:**

```bash
# Jika menggunakan Homebrew
brew services start mysql
```

**Linux:**

```bash
sudo systemctl start mysql
```

### Error: "The Mix manifest does not exist"

```bash
# Build ulang assets
npm run build
```

### Error: "Permission denied" (Storage)

```bash
# Berikan permission yang benar
chmod -R 775 storage bootstrap/cache

# Atau di Windows, pastikan folder tidak read-only
```

### Lupa Password Admin

Ubah password melalui database atau jalankan ulang seeder:

```bash
php artisan migrate:fresh --seed
```

> ⚠️ **Peringatan**: Perintah ini akan menghapus SEMUA data dan menggantinya dengan data seeder.

### Halaman Tidak Update Setelah Perubahan

```bash
# Clear semua cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# Atau sekaligus
php artisan optimize:clear
```

---

## 📞 Kontak Developer

Jika mengalami kendala atau membutuhkan bantuan lebih lanjut:

| Nama     | Rangga Dwi Prasetyo                            |
| -------- | ---------------------------------------------- |
| Email    | [ranggadwi@example.com]                        |
| GitHub   | [@RanggaDwi16](https://github.com/RanggaDwi16) |
| WhatsApp | [Contact Developer]                            |

---

## 📄 Lisensi

Project ini dibuat untuk PADRP ASSYUKRO.

---

### 👑 Administrator

- **Email**: `admin@kauman.id`
- **Password**: `password123`

### 👤 Warga

- **Email**: `ahmad.wijaya@gmail.com`
- **Password**: `password123`
- _(Atau gunakan email lain dari seed: `siti.rahayu@gmail.com`, `budi.santoso@gmail.com`, dll. Password sama.)_

## 📚 Catatan Tambahan

- **Fitur Toggle Password**: Icon mata tersedia di semua form input password untuk kenyamanan pengguna.
- **Bank Sampah Warga**: Warga tidak menginput setoran sendiri. Sampah dibawa ke posko, dan Admin yang akan menginputnya ke sistem. Saldo warga akan otomatis bertambah.

## � Lisensi

Hak Cipta © 2026 Dusun Kauman, Desa Deras. All rights reserved.

## 🙏 Terima Kasih

Terima kasih telah menggunakan aplikasi PADRP ASSYUKRO. Semoga aplikasi ini bermanfaat untuk kemajuan organisasi.

**© 2025 PADRP ASSYUKRO - All Rights Reserved**

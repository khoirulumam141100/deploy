# 🚀 Panduan Instalasi Cepat - PADRP ASSYUKRO

Panduan singkat untuk menginstal dan menjalankan aplikasi PADRP ASSYUKRO di komputer lokal.

---

## ⚡ Instalasi Cepat (5 Menit)

### Prasyarat

Pastikan sudah terinstal:

-   ✅ PHP 8.2+
-   ✅ Composer
-   ✅ Node.js 18+
-   ✅ MySQL 8.0+
-   ✅ Git

### Langkah-langkah

```bash
# 1. Clone repository
git clone https://github.com/RanggaDwi16/web-assyukro.git
cd web-assyukro

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di file .env
# Edit DB_DATABASE, DB_USERNAME, DB_PASSWORD sesuai MySQL Anda

# 5. Buat database MySQL
mysql -u root -p -e "CREATE DATABASE pdarp_assyukro;"

# 6. Migrasi dan seeding
php artisan migrate:fresh --seed

# 7. Build assets
npm run build

# 8. Jalankan server
php artisan serve
```

### 🌐 Akses Aplikasi

Buka browser dan akses: **http://localhost:8000**

---

## 🔑 Login

### Admin

-   **Email**: `admin@gmail.com`
-   **Password**: `password123`

### Anggota Demo

-   **Email**: `rangga@gmail.com`
-   **Password**: `password123`

---

## ❓ Bantuan

Jika ada kendala, lihat [README.md](README.md) untuk panduan lengkap dan troubleshooting.

---

**© 2025 PADRP ASSYUKRO**

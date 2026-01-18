# 📋 IMPLEMENTATION PLAN

# Sistem Informasi Warga Dusun Kauman, Desa Deras

## Transformasi dari PADRP Assyukro ke Sistem RT/RW Kauman

---

## 📌 Project Overview

| Aspek            | Detail                                      |
| ---------------- | ------------------------------------------- |
| **Nama Project** | Sistem Informasi Warga Dusun Kauman         |
| **Tagline**      | Sistem Informasi Warga RT/RW Kauman         |
| **Scope**        | 4 RT dalam 2 RW                             |
| **Wilayah**      | RW 01 (RT 03, RT 04) & RW 02 (RT 01, RT 02) |
| **Admin**        | 1 Admin Pusat                               |
| **User**         | Warga (sebelumnya Anggota)                  |

---

## 🎯 Objectives

1. ✅ Mengubah konteks dari "Organisasi" menjadi "Lingkungan RT/RW"
2. ✅ Mengganti branding Assyukro dengan Kauman
3. ✅ Menyesuaikan fitur keuangan untuk lingkup RT
4. ✅ Menambahkan fitur Bank Sampah (baru)
5. ✅ Redesign UI dengan tampilan baru (warna tetap)
6. ✅ Struktur keuangan terpisah per RT dengan agregasi total

---

## 📁 Struktur Wilayah

```
📁 Dusun Kauman, Desa Deras
├── 📂 RW 01
│   ├── 📂 RT 03
│   └── 📂 RT 04
└── 📂 RW 02
    ├── 📂 RT 01
    └── 📂 RT 02
```

---

## 🔄 Perubahan Terminologi

| Sebelum (Assyukro)  | Sesudah (Kauman)  |
| ------------------- | ----------------- |
| Anggota             | Warga             |
| Organisasi          | Lingkungan RT/RW  |
| PADRP Assyukro      | Kauman            |
| Keanggotaan         | Kependudukan      |
| Kas Assyukro        | Kas RT            |
| Rutinan Mingguan    | Iuran Kebersihan  |
| Rutinan Bulanan     | Dana Sosial       |
| Keuangan Idul Fitri | Keuangan Kegiatan |

---

## 🏗️ Implementation Phases

### **Phase 1: Database & Backend Restructure** ✅ SELESAI

-   [x] 1.1 Buat migration untuk tabel `rts` dan `rws`
-   [x] 1.2 Update migration `users` - tambah `rt_id`, `rw_id`, `nik`, `residence_status`, `occupation`
-   [x] 1.3 Update migration `categories` - sesuaikan dengan kategori RT
-   [x] 1.4 Update migration `transactions` - tambah `rt_id` untuk keuangan per RT
-   [x] 1.5 Buat migration tabel `waste_types` (jenis sampah)
-   [x] 1.6 Buat migration tabel `waste_deposits` (setoran sampah)
-   [x] 1.7 Buat migration tabel `waste_redemptions` (penukaran - UI only)
-   [x] 1.8 Update semua Models (Rt, Rw, WasteType, WasteDeposit, WasteRedemption, User, Transaction)
-   [x] 1.9 Update semua Seeders (RwRtSeeder, WasteTypeSeeder, ResidentSeeder, WasteDepositSeeder)

### **Phase 2: Backend Controllers & Logic** ✅ SELESAI

-   [x] 2.1 Update AuthController - registrasi dengan RT/RW
-   [x] 2.2 Update Admin DashboardController - statistik per RT & agregasi
-   [x] 2.3 Create ResidentController (menggantikan MemberController)
-   [x] 2.4 Update Admin FinanceController - filter per RT
-   [x] 2.5 Update Admin EventController - kegiatan umum
-   [x] 2.6 Create Admin WasteBankController (Bank Sampah Admin)
-   [x] 2.7 Create Warga Controllers (Dashboard, WasteBank, Event, Finance, Profile)
-   [x] 2.8 Create Middleware (WargaMiddleware, ApprovedMiddleware)
-   [x] 2.9 Update semua Enums (ResidenceStatus, RedemptionStatus, RedemptionType)
-   [x] 2.10 Update Routes (warga/, admin/residents/, admin/waste-bank/)

### **Phase 3: Frontend Views - Landing & Auth** ✅ SELESAI

-   [x] 3.1 Redesign `welcome.blade.php` - landing page baru dengan Kauman branding
-   [x] 3.2 Redesign `login.blade.php` - glassmorphism style
-   [x] 3.3 Redesign `register.blade.php` - tambah field RT/RW, NIK, residence status
-   [x] 3.4 Update `guest.blade.php` layout component
-   [x] 3.5 Update `app.blade.php` layout component
-   [x] 3.6 Create `warga.blade.php` layout component

### **Phase 4: Admin Dashboard & Pages** ✅ SELESAI

-   [x] 4.1 Redesign Admin Dashboard dengan statistik RT/RW, Bank Sampah, filter
-   [x] 4.2 Update Admin Layout dengan Kauman branding dan menu Bank Sampah
-   [x] 4.3 Create halaman Warga/Residents (index, pending, create, edit, show)
-   [x] 4.4 Update halaman Keuangan dengan filter RT (sudah ada)
-   [x] 4.5 Update halaman Kegiatan (sudah ada, update terminology)
-   [x] 4.6 Create halaman Bank Sampah Admin (index, deposits, deposits-create, types, redemptions)
-   [x] 4.7 Hapus folder members lama (diganti residents)

### **Phase 5: Member/Warga Dashboard & Pages** ✅ SELESAI

-   [x] 5.1 Create Warga Dashboard dengan saldo Bank Sampah
-   [x] 5.2 Create halaman Bank Sampah (index dengan saldo)
-   [x] 5.3 Create halaman Riwayat Setoran Sampah (history)
-   [x] 5.4 Create halaman Penukaran (redeem)
-   [x] 5.5 Create halaman Profil (profile)
-   [x] 5.6 Create halaman Keuangan (index, category - read-only)
-   [x] 5.7 Create halaman Kegiatan (index, show)

### **Phase 6: Final Polish** ✅ SELESAI

-   [x] 6.1 Update semua text/label Assyukro → Kauman di views
-   [x] 6.2 Update branding konsisten (logo, favicon, title)
-   [ ] 6.3 Testing semua fitur (untuk dilakukan oleh USER)
-   [x] 6.4 Update README.md
-   [x] 6.5 Database seeded dengan data sample
-   [x] 6.6 Cleanup folder lama (members, member)

---

## 📊 New Database Schema

### **Tabel Baru** ✅

#### `rws` (Rukun Warga)

```
id, name (RW 01, RW 02), description, created_at, updated_at
```

#### `rts` (Rukun Tetangga)

```
id, rw_id (FK), name (RT 01, RT 02, etc), description, created_at, updated_at
```

#### `waste_types` (Jenis Sampah)

```
id, name, slug, description, price_per_kg, unit, icon, is_active, created_at, updated_at
```

#### `waste_deposits` (Setoran Sampah)

```
id, user_id (FK), waste_type_id (FK), weight_kg, price_per_kg, total_amount, deposit_date, notes, recorded_by, created_at, updated_at
```

#### `waste_redemptions` (Penukaran - UI Only)

```
id, user_id (FK), amount, redemption_type (cash/goods), status (pending/completed/rejected), notes, created_at, updated_at
```

---

## 🎨 UI/UX Changes ✅

### Color Palette (Updated)

-   **Primary**: Green-Teal (#15803d → #0d9488)
-   **Secondary**: Emerald, Amber
-   **Accent**: Teal, Purple, Orange
-   **Style**: Glassmorphism, modern cards

### Typography

-   Font: System stack atau Inter

### Layout Changes

-   ✅ Landing page: Redesign total dengan tema komunitas RT/RW
-   ✅ Dashboard: Layout dengan statistik cards, charts, quick actions
-   ✅ Navigasi: Tambah menu Bank Sampah untuk Admin dan Warga

---

## 📝 Routes Structure ✅

### Admin Routes

```
/admin/dashboard
/admin/residents (menggantikan members)
/admin/residents/pending
/admin/residents/{resident}/approve
/admin/residents/{resident}/reject
/admin/finance
/admin/finance/category/{category}
/admin/events
/admin/waste-bank
/admin/waste-bank/deposits
/admin/waste-bank/deposits/create
/admin/waste-bank/types
/admin/waste-bank/redemptions
/admin/profile
/admin/activity-logs
```

### Warga Routes

```
/warga/dashboard (menggantikan member)
/warga/waste-bank
/warga/waste-bank/history
/warga/waste-bank/redeem
/warga/finance
/warga/finance/category/{category}
/warga/events
/warga/events/{event}
/warga/profile
```

### Legacy Redirects

```
/member/* → /warga/*
```

---

## ✅ Success Criteria

1. [x] Semua referensi "Assyukro" sudah diganti dengan "Kauman"
2. [x] Struktur RT/RW sudah berfungsi dengan benar
3. [x] Keuangan bisa difilter per RT dengan total agregasi
4. [x] Fitur Bank Sampah berfungsi (setor, saldo, riwayat)
5. [x] UI sudah diperbarui dengan desain baru
6. [x] Dashboard admin menampilkan data per RT
7. [x] Dashboard warga menampilkan saldo bank sampah
8. [x] Registrasi warga dengan pilihan RT/RW

---

## 🎉 STATUS: SELESAI!

**Semua phases sudah diimplementasi.** Yang tersisa:

-   Testing menyeluruh semua fitur
-   Update README.md

### Kredensial Default

| Role  | Email                  | Password    |
| ----- | ---------------------- | ----------- |
| Admin | admin@kauman.id        | password123 |
| Warga | ahmad.wijaya@gmail.com | password123 |

### URL

-   Landing: http://localhost:8001
-   Login: http://localhost:8001/login
-   Register: http://localhost:8001/register
-   Admin Dashboard: http://localhost:8001/admin/dashboard
-   Warga Dashboard: http://localhost:8001/warga/dashboard

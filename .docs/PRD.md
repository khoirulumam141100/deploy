# Product Requirements Document (PRD)

# Website Organisasi Pemuda PADRP ASSYUKRO

---

## 📋 Document Information

| Item               | Detail                          |
| ------------------ | ------------------------------- |
| **Nama Project**   | Website PADRP ASSYUKRO          |
| **Versi Dokumen**  | 1.0                             |
| **Tanggal Dibuat** | 25 Desember 2024                |
| **Tipe Project**   | Skripsi - Website Organisasi    |
| **Tech Stack**     | Laravel 11, Tailwind CSS, MySQL |

---

## 1. Executive Summary

### 1.1 Latar Belakang

PADRP ASSYUKRO (Persatuan Anak Daerah, Pesantren, dan Rantau) adalah sebuah organisasi pemuda yang membutuhkan sistem informasi berbasis website untuk mengelola data keanggotaan, keuangan, dan kegiatan organisasi secara transparan dan efisien.

### 1.2 Tujuan Project

Membangun website yang dapat:

1. Mengelola data keanggotaan organisasi secara digital
2. Mencatat dan menampilkan data keuangan organisasi secara transparan
3. Menginformasikan kegiatan-kegiatan organisasi kepada anggota
4. Menyediakan sistem pendaftaran anggota baru dengan approval admin

### 1.3 Target Pengguna

| Role        | Deskripsi                                                                                  |
| ----------- | ------------------------------------------------------------------------------------------ |
| **Admin**   | Pengurus organisasi yang bertugas mengelola seluruh data (keanggotaan, keuangan, kegiatan) |
| **Anggota** | Member organisasi yang dapat melihat informasi kegiatan dan keuangan secara transparan     |

---

## 2. Functional Requirements

### 2.1 Modul Autentikasi

#### 2.1.1 Login

| ID       | Requirement                                                                                              |
| -------- | -------------------------------------------------------------------------------------------------------- |
| AUTH-001 | Sistem harus menyediakan halaman login untuk Admin dan Anggota                                           |
| AUTH-002 | Login menggunakan email dan password                                                                     |
| AUTH-003 | Sistem harus membedakan redirect berdasarkan role (Admin → Dashboard Admin, Anggota → Dashboard Anggota) |
| AUTH-004 | Sistem harus menyediakan fitur "Lupa Password"                                                           |
| AUTH-005 | Sistem harus menyediakan fitur logout                                                                    |

#### 2.1.2 Registrasi Anggota Baru

| ID      | Requirement                                                                                                                   |
| ------- | ----------------------------------------------------------------------------------------------------------------------------- |
| REG-001 | Sistem harus menyediakan form pendaftaran anggota baru yang dapat diakses publik                                              |
| REG-002 | Data pendaftaran yang diperlukan: Nama Lengkap, Email, Password, Nomor Telepon/WhatsApp, Alamat, Tanggal Lahir, Jenis Kelamin |
| REG-003 | Pendaftar baru akan memiliki status "Pending" sampai di-approve oleh Admin                                                    |
| REG-004 | Sistem harus menampilkan notifikasi bahwa pendaftaran berhasil dan menunggu approval                                          |
| REG-005 | Pendaftar dengan status "Pending" tidak dapat login sampai di-approve                                                         |

---

### 2.2 Modul Admin

#### 2.2.1 Dashboard Admin

| ID      | Requirement                                                                                                         |
| ------- | ------------------------------------------------------------------------------------------------------------------- |
| ADM-001 | Menampilkan ringkasan statistik: Total Anggota Aktif, Pending Approval, Total Saldo Keseluruhan, Kegiatan Bulan Ini |
| ADM-002 | Menampilkan daftar pendaftaran anggota yang menunggu approval                                                       |
| ADM-003 | Menampilkan ringkasan keuangan per kategori                                                                         |
| ADM-004 | Menampilkan kegiatan terbaru                                                                                        |

#### 2.2.2 Manajemen Keanggotaan

| ID      | Requirement                                                             |
| ------- | ----------------------------------------------------------------------- |
| MBR-001 | Admin dapat melihat daftar seluruh anggota (aktif, non-aktif, pending)  |
| MBR-002 | Admin dapat meng-approve pendaftaran anggota baru                       |
| MBR-003 | Admin dapat me-reject pendaftaran anggota dengan alasan                 |
| MBR-004 | Admin dapat menambah anggota baru secara manual                         |
| MBR-005 | Admin dapat mengedit data anggota                                       |
| MBR-006 | Admin dapat menonaktifkan/mengaktifkan status anggota                   |
| MBR-007 | Admin dapat menghapus data anggota                                      |
| MBR-008 | Admin dapat mencari dan memfilter anggota berdasarkan nama, status, dll |
| MBR-009 | Admin dapat melihat detail lengkap profil anggota                       |

**Data Anggota yang Disimpan:**

- ID Anggota (auto-generate)
- Nama Lengkap
- Email
- Password (encrypted)
- Nomor Telepon/WhatsApp
- Alamat Lengkap
- Tanggal Lahir
- Jenis Kelamin
- Tanggal Bergabung
- Status (Pending, Aktif, Non-Aktif)
- Role (Admin, Anggota)

#### 2.2.3 Manajemen Keuangan

| ID      | Requirement                                                                                                     |
| ------- | --------------------------------------------------------------------------------------------------------------- |
| FIN-001 | Admin dapat mengelola 4 kategori keuangan: Kas Assyukro, Rutinan Mingguan, Rutinan Bulanan, Keuangan Idul Fitri |
| FIN-002 | Admin dapat menambah transaksi baru (pemasukan/pengeluaran)                                                     |
| FIN-003 | Admin dapat mengedit transaksi yang sudah ada                                                                   |
| FIN-004 | Admin dapat menghapus transaksi                                                                                 |
| FIN-005 | Sistem harus menghitung saldo otomatis per kategori                                                             |
| FIN-006 | Sistem harus menghitung total saldo keseluruhan                                                                 |
| FIN-007 | Admin dapat melihat riwayat transaksi per kategori                                                              |
| FIN-008 | Admin dapat memfilter transaksi berdasarkan tanggal, jenis (masuk/keluar), kategori                             |
| FIN-009 | Admin dapat melihat laporan keuangan per kategori                                                               |

**Kategori Keuangan:**
| No | Nama Kategori | Deskripsi |
|----|---------------|-----------|
| 1 | Kas Assyukro | Keuangan utama organisasi |
| 2 | Rutinan Mingguan | Keuangan untuk kegiatan rutin mingguan |
| 3 | Rutinan Bulanan | Keuangan untuk kegiatan rutin bulanan |
| 4 | Keuangan Idul Fitri | Keuangan khusus untuk kegiatan Idul Fitri |

**Data Transaksi yang Disimpan:**

- ID Transaksi
- Kategori Keuangan
- Jenis Transaksi (Pemasukan/Pengeluaran)
- Nominal
- Keterangan/Deskripsi
- Tanggal Transaksi
- Dicatat Oleh (Admin yang input)
- Tanggal Input
- Tanggal Update

#### 2.2.4 Manajemen Kegiatan

| ID      | Requirement                                                                  |
| ------- | ---------------------------------------------------------------------------- |
| EVT-001 | Admin dapat menambah kegiatan baru                                           |
| EVT-002 | Admin dapat mengedit kegiatan                                                |
| EVT-003 | Admin dapat menghapus kegiatan                                               |
| EVT-004 | Admin dapat melihat daftar seluruh kegiatan                                  |
| EVT-005 | Admin dapat memfilter kegiatan berdasarkan status (akan datang, sudah lewat) |
| EVT-006 | Sistem harus secara otomatis menandai kegiatan yang sudah lewat              |

**Data Kegiatan yang Disimpan:**

- ID Kegiatan
- Nama Kegiatan
- Deskripsi Kegiatan
- Tanggal Pelaksanaan
- Waktu Mulai
- Waktu Selesai
- Lokasi
- Status (Akan Datang, Sedang Berlangsung, Selesai)
- Dibuat Oleh (Admin)
- Tanggal Dibuat
- Tanggal Update

---

### 2.3 Modul Anggota

#### 2.3.1 Dashboard Anggota

| ID      | Requirement                                       |
| ------- | ------------------------------------------------- |
| USR-001 | Menampilkan kegiatan yang akan datang             |
| USR-002 | Menampilkan ringkasan saldo per kategori keuangan |
| USR-003 | Menampilkan total anggota aktif                   |

#### 2.3.2 Melihat Kegiatan

| ID      | Requirement                                            |
| ------- | ------------------------------------------------------ |
| USR-004 | Anggota dapat melihat daftar kegiatan yang akan datang |
| USR-005 | Anggota dapat melihat daftar kegiatan yang sudah lewat |
| USR-006 | Anggota dapat melihat detail kegiatan                  |
| USR-007 | Anggota dapat memfilter kegiatan berdasarkan status    |

#### 2.3.3 Melihat Keuangan

| ID      | Requirement                                                      |
| ------- | ---------------------------------------------------------------- |
| USR-008 | Anggota dapat melihat saldo per kategori keuangan                |
| USR-009 | Anggota dapat melihat riwayat transaksi per kategori (read-only) |
| USR-010 | Anggota dapat melihat total saldo keseluruhan                    |

#### 2.3.4 Profil Anggota

| ID      | Requirement                                                           |
| ------- | --------------------------------------------------------------------- |
| USR-011 | Anggota dapat melihat profil sendiri                                  |
| USR-012 | Anggota dapat mengedit data profil sendiri (kecuali email dan status) |
| USR-013 | Anggota dapat mengubah password                                       |

---

## 3. Non-Functional Requirements

### 3.1 Keamanan

| ID      | Requirement                                                         |
| ------- | ------------------------------------------------------------------- |
| SEC-001 | Password harus di-hash menggunakan bcrypt                           |
| SEC-002 | Implementasi CSRF protection pada semua form                        |
| SEC-003 | Implementasi middleware untuk role-based access control             |
| SEC-004 | Session timeout setelah periode tidak aktif                         |
| SEC-005 | Validasi input pada semua form untuk mencegah SQL injection dan XSS |

### 3.2 Performa

| ID      | Requirement                                        |
| ------- | -------------------------------------------------- |
| PER-001 | Halaman harus load dalam waktu kurang dari 3 detik |
| PER-002 | Implementasi pagination untuk data yang banyak     |
| PER-003 | Optimasi query database                            |

### 3.3 Usability

| ID      | Requirement                                    |
| ------- | ---------------------------------------------- |
| USA-001 | Desain responsif (mobile-friendly)             |
| USA-002 | Interface yang intuitif dan mudah digunakan    |
| USA-003 | Feedback yang jelas untuk setiap aksi pengguna |
| USA-004 | Konsistensi desain di seluruh halaman          |

### 3.4 Maintainability

| ID      | Requirement                              |
| ------- | ---------------------------------------- |
| MNT-001 | Kode terstruktur menggunakan pattern MVC |
| MNT-002 | Dokumentasi kode yang jelas              |
| MNT-003 | Penggunaan migration untuk database      |
| MNT-004 | Penggunaan seeder untuk data awal        |

---

## 4. Database Design

### 4.1 Entity Relationship Diagram (ERD) - Textual

```
┌─────────────────┐       ┌─────────────────┐
│     users       │       │   categories    │
├─────────────────┤       ├─────────────────┤
│ id (PK)         │       │ id (PK)         │
│ name            │       │ name            │
│ email (unique)  │       │ slug            │
│ password        │       │ description     │
│ phone           │       │ created_at      │
│ address         │       │ updated_at      │
│ birth_date      │       └────────┬────────┘
│ gender          │                │
│ role            │                │
│ status          │                │
│ joined_at       │                │
│ created_at      │                │
│ updated_at      │                │
└────────┬────────┘                │
         │                         │
         │                         │
         ▼                         ▼
┌─────────────────┐       ┌─────────────────┐
│  transactions   │       │     events      │
├─────────────────┤       ├─────────────────┤
│ id (PK)         │       │ id (PK)         │
│ category_id(FK) │       │ title           │
│ user_id (FK)    │       │ description     │
│ type            │       │ event_date      │
│ amount          │       │ start_time      │
│ description     │       │ end_time        │
│ transaction_date│       │ location        │
│ created_at      │       │ status          │
│ updated_at      │       │ created_by (FK) │
└─────────────────┘       │ created_at      │
                          │ updated_at      │
                          └─────────────────┘
```

### 4.2 Tabel Database

#### 4.2.1 Tabel `users`

| Kolom      | Tipe Data                           | Constraint         | Keterangan                                |
| ---------- | ----------------------------------- | ------------------ | ----------------------------------------- |
| id         | bigint                              | PK, auto-increment | ID unik user                              |
| name       | varchar(255)                        | NOT NULL           | Nama lengkap                              |
| email      | varchar(255)                        | UNIQUE, NOT NULL   | Email untuk login                         |
| password   | varchar(255)                        | NOT NULL           | Password (hashed)                         |
| phone      | varchar(20)                         | NOT NULL           | Nomor telepon/WA                          |
| address    | text                                | NOT NULL           | Alamat lengkap                            |
| birth_date | date                                | NOT NULL           | Tanggal lahir                             |
| gender     | enum('L','P')                       | NOT NULL           | Jenis kelamin                             |
| role       | enum('admin','anggota')             | DEFAULT 'anggota'  | Role pengguna                             |
| status     | enum('pending','active','inactive') | DEFAULT 'pending'  | Status keanggotaan                        |
| joined_at  | date                                | NULL               | Tanggal bergabung (diisi saat di-approve) |
| created_at | timestamp                           |                    | Tanggal dibuat                            |
| updated_at | timestamp                           |                    | Tanggal update                            |

#### 4.2.2 Tabel `categories`

| Kolom       | Tipe Data    | Constraint         | Keterangan         |
| ----------- | ------------ | ------------------ | ------------------ |
| id          | bigint       | PK, auto-increment | ID unik kategori   |
| name        | varchar(100) | NOT NULL           | Nama kategori      |
| slug        | varchar(100) | UNIQUE, NOT NULL   | Slug untuk URL     |
| description | text         | NULL               | Deskripsi kategori |
| created_at  | timestamp    |                    | Tanggal dibuat     |
| updated_at  | timestamp    |                    | Tanggal update     |

**Data Awal (Seeder):**

1. Kas Assyukro (kas-assyukro)
2. Rutinan Mingguan (rutinan-mingguan)
3. Rutinan Bulanan (rutinan-bulanan)
4. Keuangan Idul Fitri (keuangan-idul-fitri)

#### 4.2.3 Tabel `transactions`

| Kolom            | Tipe Data                | Constraint         | Keterangan           |
| ---------------- | ------------------------ | ------------------ | -------------------- |
| id               | bigint                   | PK, auto-increment | ID unik transaksi    |
| category_id      | bigint                   | FK → categories.id | Kategori keuangan    |
| user_id          | bigint                   | FK → users.id      | Admin yang input     |
| type             | enum('income','expense') | NOT NULL           | Jenis transaksi      |
| amount           | decimal(15,2)            | NOT NULL           | Nominal transaksi    |
| description      | text                     | NOT NULL           | Keterangan transaksi |
| transaction_date | date                     | NOT NULL           | Tanggal transaksi    |
| created_at       | timestamp                |                    | Tanggal dibuat       |
| updated_at       | timestamp                |                    | Tanggal update       |

#### 4.2.4 Tabel `events`

| Kolom       | Tipe Data                              | Constraint         | Keterangan          |
| ----------- | -------------------------------------- | ------------------ | ------------------- |
| id          | bigint                                 | PK, auto-increment | ID unik kegiatan    |
| title       | varchar(255)                           | NOT NULL           | Nama kegiatan       |
| description | text                                   | NOT NULL           | Deskripsi kegiatan  |
| event_date  | date                                   | NOT NULL           | Tanggal pelaksanaan |
| start_time  | time                                   | NOT NULL           | Waktu mulai         |
| end_time    | time                                   | NOT NULL           | Waktu selesai       |
| location    | varchar(255)                           | NOT NULL           | Lokasi kegiatan     |
| status      | enum('upcoming','ongoing','completed') | DEFAULT 'upcoming' | Status kegiatan     |
| created_by  | bigint                                 | FK → users.id      | Admin yang membuat  |
| created_at  | timestamp                              |                    | Tanggal dibuat      |
| updated_at  | timestamp                              |                    | Tanggal update      |

---

## 5. User Interface Design

### 5.1 Sitemap

```
Website PADRP ASSYUKRO
│
├── Public Pages
│   ├── Landing Page (/)
│   ├── Login (/login)
│   ├── Register (/register)
│   └── Forgot Password (/forgot-password)
│
├── Admin Panel (/admin)
│   ├── Dashboard (/admin/dashboard)
│   ├── Keanggotaan
│   │   ├── Daftar Anggota (/admin/members)
│   │   ├── Pending Approval (/admin/members/pending)
│   │   ├── Tambah Anggota (/admin/members/create)
│   │   ├── Detail Anggota (/admin/members/{id})
│   │   └── Edit Anggota (/admin/members/{id}/edit)
│   ├── Keuangan
│   │   ├── Overview (/admin/finance)
│   │   ├── Per Kategori (/admin/finance/{category})
│   │   ├── Tambah Transaksi (/admin/finance/create)
│   │   └── Edit Transaksi (/admin/finance/{id}/edit)
│   ├── Kegiatan
│   │   ├── Daftar Kegiatan (/admin/events)
│   │   ├── Tambah Kegiatan (/admin/events/create)
│   │   ├── Detail Kegiatan (/admin/events/{id})
│   │   └── Edit Kegiatan (/admin/events/{id}/edit)
│   └── Profil Admin (/admin/profile)
│
└── Member Area (/member)
    ├── Dashboard (/member/dashboard)
    ├── Kegiatan
    │   ├── Daftar Kegiatan (/member/events)
    │   └── Detail Kegiatan (/member/events/{id})
    ├── Keuangan
    │   ├── Overview (/member/finance)
    │   └── Per Kategori (/member/finance/{category})
    └── Profil (/member/profile)
```

### 5.2 Wireframe Descriptions

#### 5.2.1 Landing Page

- Header dengan logo dan nama organisasi "PADRP ASSYUKRO"
- Hero section dengan tagline organisasi
- Section penjelasan singkat tentang organisasi
- CTA buttons: "Masuk" dan "Daftar Jadi Anggota"
- Footer dengan informasi kontak

#### 5.2.2 Login Page

- Form login dengan input email dan password
- Link "Lupa Password?"
- Link ke halaman registrasi
- Desain clean dan modern

#### 5.2.3 Register Page

- Form pendaftaran lengkap
- Validasi real-time
- Pesan sukses setelah registrasi

#### 5.2.4 Admin Dashboard

- Sidebar navigasi (collapsible)
- Header dengan profil admin dan logout
- Cards statistik: Total Anggota, Pending Approval, Total Saldo, Kegiatan Bulan Ini
- Section pending approval dengan quick action
- Chart/grafik ringkasan keuangan
- List kegiatan terbaru

#### 5.2.5 Member Dashboard

- Sidebar navigasi sederhana
- Welcome message
- Cards: Kegiatan Mendatang, Total Saldo
- Preview kegiatan yang akan datang
- Ringkasan saldo per kategori

---

## 6. Technology Stack

### 6.1 Backend

| Technology | Version | Purpose              |
| ---------- | ------- | -------------------- |
| PHP        | ^8.2    | Programming Language |
| Laravel    | 11.x    | PHP Framework        |
| MySQL      | 8.x     | Database             |
| Composer   | Latest  | Dependency Manager   |

### 6.2 Frontend

| Technology   | Version | Purpose                   |
| ------------ | ------- | ------------------------- |
| Tailwind CSS | 3.x     | CSS Framework             |
| Alpine.js    | 3.x     | Lightweight JS Framework  |
| Blade        | -       | Laravel Templating Engine |

### 6.3 Development Tools

| Tool           | Purpose                    |
| -------------- | -------------------------- |
| Laravel Vite   | Asset bundling             |
| Laravel Breeze | Authentication scaffolding |
| npm            | JavaScript package manager |

---

## 7. Development Phases

### Phase 1: Project Setup & Authentication (Week 1)

- [ ] Setup Laravel 11 project
- [ ] Configure database (MySQL)
- [ ] Install and configure Tailwind CSS
- [ ] Setup Laravel Breeze untuk authentication
- [ ] Customisasi login/register
- [ ] Implementasi role-based access
- [ ] Buat middleware untuk admin dan anggota
- [ ] Buat migration dan seeder untuk users dan categories

### Phase 2: Admin - Manajemen Keanggotaan (Week 2)

- [ ] Buat layout admin (sidebar, header)
- [ ] Dashboard admin dengan statistik
- [ ] CRUD anggota
- [ ] Approval system untuk pendaftaran baru
- [ ] Fitur search dan filter anggota

### Phase 3: Admin - Manajemen Keuangan (Week 3)

- [ ] CRUD transaksi keuangan
- [ ] Implementasi 4 kategori keuangan
- [ ] Perhitungan saldo otomatis
- [ ] Filter dan search transaksi
- [ ] Laporan keuangan per kategori

### Phase 4: Admin - Manajemen Kegiatan (Week 4)

- [ ] CRUD kegiatan
- [ ] Auto-update status kegiatan
- [ ] Filter kegiatan (upcoming/completed)

### Phase 5: Member Area (Week 5)

- [ ] Layout member area
- [ ] Dashboard anggota
- [ ] View kegiatan (read-only)
- [ ] View keuangan (read-only)
- [ ] Profil anggota (view & edit)

### Phase 6: Polish & Testing (Week 6)

- [ ] UI/UX improvements
- [ ] Responsive testing
- [ ] Bug fixing
- [ ] Performance optimization
- [ ] Final review

---

## 8. Success Metrics

| Metric         | Target                                     |
| -------------- | ------------------------------------------ |
| Fungsionalitas | 100% fitur berjalan sesuai requirement     |
| Keamanan       | Tidak ada vulnerability pada auth dan data |
| Performance    | Load time < 3 detik                        |
| Responsiveness | Tampil baik di mobile, tablet, dan desktop |
| Code Quality   | Mengikuti best practice Laravel            |

---

## 9. Appendix

### 9.1 Glossary

| Term             | Definition                                   |
| ---------------- | -------------------------------------------- |
| PADRP            | Persatuan Anak Daerah, Pesantren, dan Rantau |
| Kas Assyukro     | Keuangan utama organisasi                    |
| Rutinan Mingguan | Dana untuk kegiatan rutin setiap minggu      |
| Rutinan Bulanan  | Dana untuk kegiatan rutin setiap bulan       |
| Approval         | Proses persetujuan pendaftaran oleh admin    |

### 9.2 References

- Laravel 11 Documentation: https://laravel.com/docs/11.x
- Tailwind CSS Documentation: https://tailwindcss.com/docs
- Alpine.js Documentation: https://alpinejs.dev/

---

**Document prepared for:** Skripsi - Website Organisasi PADRP ASSYUKRO  
**Status:** Draft v1.0 - Ready for Review

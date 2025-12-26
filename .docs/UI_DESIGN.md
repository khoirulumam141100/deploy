# UI/UX Design Specification

# Website PADRP ASSYUKRO

---

## 1. Design Philosophy

### 1.1 Brand Identity

- **Nama Organisasi:** PADRP ASSYUKRO
- **Tagline:** "Persatuan Anak Daerah, Pesantren, dan Rantau"
- **Brand Personality:** Profesional, Modern, Terpercaya, Transparan
- **Color Theme:** Blue-based (kepercayaan, profesionalisme) dengan aksen hijau (pertumbuhan, harmoni)

### 1.2 Design Principles

1. **Clean & Modern:** Tampilan bersih dengan white space yang cukup
2. **User-Friendly:** Navigasi yang intuitif dan mudah dipahami
3. **Consistent:** Konsistensi elemen visual di seluruh halaman
4. **Responsive:** Optimal di semua ukuran layar
5. **Accessible:** Dapat diakses oleh semua pengguna

---

## 2. Color System

### 2.1 Primary Palette

```
Primary Blue (Trust & Professionalism)
├── Primary-50:  #eff6ff (Background light)
├── Primary-100: #dbeafe (Hover states)
├── Primary-200: #bfdbfe (Borders)
├── Primary-500: #3b82f6 (Main accent)
├── Primary-600: #2563eb (Buttons, links)
├── Primary-700: #1d4ed8 (Hover buttons)
└── Primary-900: #1e3a8a (Text dark)
```

### 2.2 Secondary Palette

```
Emerald Green (Growth & Success)
├── Secondary-50:  #ecfdf5
├── Secondary-100: #d1fae5
├── Secondary-500: #10b981
├── Secondary-600: #059669
└── Secondary-700: #047857
```

### 2.3 Semantic Colors

```
Success:  #22c55e (Green)
Warning:  #f59e0b (Amber)
Error:    #ef4444 (Red)
Info:     #3b82f6 (Blue)
```

### 2.4 Neutral Colors

```
├── Gray-50:  #f9fafb (Page background)
├── Gray-100: #f3f4f6 (Card background alt)
├── Gray-200: #e5e7eb (Borders)
├── Gray-300: #d1d5db (Disabled states)
├── Gray-500: #6b7280 (Secondary text)
├── Gray-700: #374151 (Primary text)
├── Gray-800: #1f2937 (Headings)
└── Gray-900: #111827 (Dark text)
```

---

## 3. Typography

### 3.1 Font Family

```
Primary: 'Inter', sans-serif
Fallback: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif
```

### 3.2 Font Scale

```
Display:    3rem (48px)  - Hero sections
H1:         2.25rem (36px) - Page titles
H2:         1.875rem (30px) - Section headers
H3:         1.5rem (24px) - Subsection headers
H4:         1.25rem (20px) - Card titles
H5:         1.125rem (18px) - Subheadings
Body Large: 1.125rem (18px) - Important text
Body:       1rem (16px) - Default text
Body Small: 0.875rem (14px) - Secondary text
Caption:    0.75rem (12px) - Labels, hints
```

### 3.3 Font Weights

```
Regular:   400
Medium:    500
Semibold:  600
Bold:      700
```

---

## 4. Spacing System

### 4.1 Base Unit: 4px

```
Space-1:  0.25rem (4px)
Space-2:  0.5rem (8px)
Space-3:  0.75rem (12px)
Space-4:  1rem (16px)
Space-5:  1.25rem (20px)
Space-6:  1.5rem (24px)
Space-8:  2rem (32px)
Space-10: 2.5rem (40px)
Space-12: 3rem (48px)
Space-16: 4rem (64px)
Space-20: 5rem (80px)
```

---

## 5. Component Library

### 5.1 Buttons

#### Primary Button

```
┌────────────────────────┐
│  ●  Simpan Data        │  ← Solid blue, white text
└────────────────────────┘
States: Default → Hover (darker) → Active → Disabled (gray)
```

#### Secondary Button

```
┌────────────────────────┐
│     Batal              │  ← Gray background, dark text
└────────────────────────┘
```

#### Outline Button

```
┌────────────────────────┐
│     Lihat Detail       │  ← White bg, blue border, blue text
└────────────────────────┘
```

#### Danger Button

```
┌────────────────────────┐
│  🗑  Hapus              │  ← Red background
└────────────────────────┘
```

### 5.2 Cards

#### Stat Card

```
┌──────────────────────────────────────┐
│  📊                                  │
│  Total Anggota                       │
│  ════════════════                    │
│  156                                 │  ← Large number
│  +12 bulan ini                       │  ← Small green text
└──────────────────────────────────────┘
```

#### Content Card

```
┌──────────────────────────────────────┐
│  Card Title                     •••  │
├──────────────────────────────────────┤
│                                      │
│  Content goes here...                │
│                                      │
└──────────────────────────────────────┘
```

### 5.3 Form Elements

#### Text Input

```
┌──────────────────────────────────────┐
│  Label                               │
│  ┌────────────────────────────────┐  │
│  │  Placeholder text...           │  │
│  └────────────────────────────────┘  │
│  Helper text (optional)              │
└──────────────────────────────────────┘
```

#### Select Dropdown

```
┌──────────────────────────────────────┐
│  Kategori                            │
│  ┌────────────────────────────────┐  │
│  │  Pilih kategori...          ▼  │  │
│  └────────────────────────────────┘  │
└──────────────────────────────────────┘
```

#### Textarea

```
┌──────────────────────────────────────┐
│  Deskripsi                           │
│  ┌────────────────────────────────┐  │
│  │                                │  │
│  │  Enter description...          │  │
│  │                                │  │
│  └────────────────────────────────┘  │
└──────────────────────────────────────┘
```

### 5.4 Tables

```
┌────────────────────────────────────────────────────────────┐
│  No  │  Nama          │  Email            │  Status  │  ⋮  │
├────────────────────────────────────────────────────────────┤
│  1   │  Ahmad Fauzi   │  ahmad@mail.com   │  ● Aktif │  ⋮  │
│  2   │  Budi Santoso  │  budi@mail.com    │  ○ Pending│  ⋮ │
│  3   │  Citra Dewi    │  citra@mail.com   │  ● Aktif │  ⋮  │
├────────────────────────────────────────────────────────────┤
│  ← Prev    Page 1 of 10    Next →                          │
└────────────────────────────────────────────────────────────┘
```

### 5.5 Badges/Tags

```
● Aktif        → Green badge
○ Pending      → Yellow badge
○ Non-Aktif    → Red badge
○ Pemasukan    → Green badge
○ Pengeluaran  → Red badge
○ Akan Datang  → Blue badge
○ Selesai      → Gray badge
```

### 5.6 Alerts

```
Success Alert
┌──────────────────────────────────────────────────────┐
│  ✓  Data berhasil disimpan!                      ✕   │
└──────────────────────────────────────────────────────┘
Green background

Error Alert
┌──────────────────────────────────────────────────────┐
│  ✕  Terjadi kesalahan. Silakan coba lagi.        ✕   │
└──────────────────────────────────────────────────────┘
Red background

Warning Alert
┌──────────────────────────────────────────────────────┐
│  ⚠  Ada 5 pendaftaran yang menunggu approval.    ✕   │
└──────────────────────────────────────────────────────┘
Yellow background
```

### 5.7 Modal

```
┌──────────────────────────────────────────────────────┐
│  Konfirmasi Hapus                                ✕   │
├──────────────────────────────────────────────────────┤
│                                                      │
│  Apakah Anda yakin ingin menghapus data ini?         │
│  Tindakan ini tidak dapat dibatalkan.                │
│                                                      │
├──────────────────────────────────────────────────────┤
│                        [Batal]  [Hapus]              │
└──────────────────────────────────────────────────────┘
```

---

## 6. Page Layouts

### 6.1 Landing Page (Public)

```
┌──────────────────────────────────────────────────────────────────────────────┐
│  HEADER                                                                      │
│  ┌────┐                                              [Masuk] [Daftar]        │
│  │LOGO│  PADRP ASSYUKRO                                                      │
│  └────┘                                                                      │
├──────────────────────────────────────────────────────────────────────────────┤
│                                                                              │
│                          HERO SECTION                                        │
│                                                                              │
│                    ═══════════════════════════                               │
│                    PADRP ASSYUKRO                                            │
│                    ═══════════════════════════                               │
│                                                                              │
│                    Persatuan Anak Daerah,                                    │
│                    Pesantren, dan Rantau                                     │
│                                                                              │
│                    Platform digital untuk mengelola                          │
│                    organisasi secara transparan dan efisien                  │
│                                                                              │
│                       [Daftar Sekarang]  [Masuk]                             │
│                                                                              │
├──────────────────────────────────────────────────────────────────────────────┤
│                                                                              │
│                          FEATURES SECTION                                    │
│                                                                              │
│    ┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐          │
│    │    👥            │  │    💰            │  │    📅            │          │
│    │  Keanggotaan     │  │  Keuangan        │  │  Kegiatan        │          │
│    │  Kelola data     │  │  Transparansi    │  │  Informasi       │          │
│    │  anggota         │  │  keuangan        │  │  kegiatan        │          │
│    └──────────────────┘  └──────────────────┘  └──────────────────┘          │
│                                                                              │
├──────────────────────────────────────────────────────────────────────────────┤
│  FOOTER                                                                      │
│  © 2024 PADRP ASSYUKRO. All rights reserved.                                 │
└──────────────────────────────────────────────────────────────────────────────┘
```

### 6.2 Login Page

```
┌──────────────────────────────────────────────────────────────────────────────┐
│                                                                              │
│                         ┌────────────────────────────┐                       │
│                         │                            │                       │
│                         │         🏛️ LOGO            │                       │
│                         │    PADRP ASSYUKRO          │                       │
│                         │                            │                       │
│                         │  ────────────────────────  │                       │
│                         │                            │                       │
│                         │  Email                     │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │                      │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  Password                  │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │                      │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  [✓] Ingat saya            │                       │
│                         │                            │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │       MASUK          │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  Lupa password?            │                       │
│                         │  Belum punya akun? Daftar  │                       │
│                         │                            │                       │
│                         └────────────────────────────┘                       │
│                                                                              │
└──────────────────────────────────────────────────────────────────────────────┘
```

### 6.3 Register Page

```
┌──────────────────────────────────────────────────────────────────────────────┐
│                                                                              │
│                         ┌────────────────────────────┐                       │
│                         │         🏛️ LOGO            │                       │
│                         │    Daftar Anggota Baru     │                       │
│                         │  ────────────────────────  │                       │
│                         │                            │                       │
│                         │  Nama Lengkap              │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │                      │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  Email                     │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │                      │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  No. Telepon/WhatsApp      │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │                      │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  Alamat                    │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │                      │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  Tgl Lahir    Jenis Kelamin│                       │
│                         │  ┌─────────┐  ┌─────────┐  │                       │
│                         │  │         │  │    ▼    │  │                       │
│                         │  └─────────┘  └─────────┘  │                       │
│                         │                            │                       │
│                         │  Password                  │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │                      │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  Konfirmasi Password       │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │                      │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  ┌──────────────────────┐  │                       │
│                         │  │       DAFTAR         │  │                       │
│                         │  └──────────────────────┘  │                       │
│                         │                            │                       │
│                         │  Sudah punya akun? Masuk   │                       │
│                         │                            │                       │
│                         └────────────────────────────┘                       │
│                                                                              │
└──────────────────────────────────────────────────────────────────────────────┘
```

### 6.4 Admin Dashboard Layout

```
┌──────────────────────────────────────────────────────────────────────────────┐
│  ┌─────────────┐  ┌────────────────────────────────────────────────────────┐ │
│  │             │  │  HEADER                            🔔  👤 Admin Name ▼ │ │
│  │  SIDEBAR    │  ├────────────────────────────────────────────────────────┤ │
│  │             │  │                                                        │ │
│  │  🏛️ PADRP   │  │  Dashboard                                             │ │
│  │             │  │  ═══════════                                           │ │
│  │  ─────────  │  │                                                        │ │
│  │             │  │  ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐       │ │
│  │  📊 Dashboard│  │  │  👥    │ │  ⏳    │ │  💰    │ │  📅    │       │ │
│  │             │  │  │  156   │ │   5    │ │ Rp 12jt│ │   8    │       │ │
│  │  👥 Anggota │  │  │ Anggota│ │ Pending│ │ Saldo  │ │Kegiatan│       │ │
│  │    ├ Semua  │  │  └─────────┘ └─────────┘ └─────────┘ └─────────┘       │ │
│  │    └ Pending│  │                                                        │ │
│  │             │  │  ┌─────────────────────────────────────────────────┐   │ │
│  │  💰 Keuangan│  │  │  Pendaftaran Pending                      Lihat│   │ │
│  │             │  │  ├─────────────────────────────────────────────────┤   │ │
│  │  📅 Kegiatan│  │  │  • Ahmad (ahmad@mail.com) - 2 hari lalu        │   │ │
│  │             │  │  │    [Approve] [Reject]                          │   │ │
│  │  👤 Profil  │  │  │  • Budi (budi@mail.com) - 3 hari lalu          │   │ │
│  │             │  │  │    [Approve] [Reject]                          │   │ │
│  │  ─────────  │  │  └─────────────────────────────────────────────────┘   │ │
│  │             │  │                                                        │ │
│  │  🚪 Logout  │  │  ┌───────────────────────┐ ┌───────────────────────┐   │ │
│  │             │  │  │  Ringkasan Keuangan   │ │  Kegiatan Mendatang   │   │ │
│  │             │  │  ├───────────────────────┤ ├───────────────────────┤   │ │
│  │             │  │  │  Kas Assyukro: 5jt    │ │  • Rapat Bulanan      │   │ │
│  │             │  │  │  Rutinan Minggu: 2jt  │ │    28 Des 2024        │   │ │
│  │             │  │  │  Rutinan Bulan: 3jt   │ │  • Bakti Sosial       │   │ │
│  │             │  │  │  Idul Fitri: 2jt      │ │    02 Jan 2025        │   │ │
│  │             │  │  └───────────────────────┘ └───────────────────────┘   │ │
│  │             │  │                                                        │ │
│  └─────────────┘  └────────────────────────────────────────────────────────┘ │
└──────────────────────────────────────────────────────────────────────────────┘
```

### 6.5 Admin - Data Anggota

```
┌──────────────────────────────────────────────────────────────────────────────┐
│  SIDEBAR   │  HEADER                                                         │
│            ├─────────────────────────────────────────────────────────────────┤
│            │                                                                 │
│            │  Data Anggota                              [+ Tambah Anggota]   │
│            │  ═══════════════                                                │
│            │                                                                 │
│            │  ┌───────────────────────────────────────────────────────────┐  │
│            │  │  🔍 Cari anggota...    │ Status: [Semua ▼] │ [Filter]    │  │
│            │  └───────────────────────────────────────────────────────────┘  │
│            │                                                                 │
│            │  ┌───────────────────────────────────────────────────────────┐  │
│            │  │ No │ Nama        │ Email          │ Telepon  │Status│ Aksi│  │
│            │  ├───────────────────────────────────────────────────────────┤  │
│            │  │ 1  │Ahmad Fauzi  │ahmad@mail.com  │081234..  │●Aktif│ ⋮   │  │
│            │  │ 2  │Budi Santoso │budi@mail.com   │081234..  │●Aktif│ ⋮   │  │
│            │  │ 3  │Citra Dewi   │citra@mail.com  │081234..  │○N/A  │ ⋮   │  │
│            │  │ 4  │Deni Kurnia  │deni@mail.com   │081234..  │●Aktif│ ⋮   │  │
│            │  │ 5  │Eka Putra    │eka@mail.com    │081234..  │●Aktif│ ⋮   │  │
│            │  ├───────────────────────────────────────────────────────────┤  │
│            │  │  ◄ Prev    1  2  3  4  5  ...  10    Next ►              │  │
│            │  └───────────────────────────────────────────────────────────┘  │
│            │                                                                 │
└────────────┴─────────────────────────────────────────────────────────────────┘

Action Dropdown (⋮):
┌─────────────────┐
│ 👁 Lihat Detail │
│ ✏️ Edit         │
│ 🔄 Toggle Status│
│ ───────────────│
│ 🗑 Hapus        │
└─────────────────┘
```

### 6.6 Admin - Keuangan Overview

```
┌──────────────────────────────────────────────────────────────────────────────┐
│  SIDEBAR   │  HEADER                                                         │
│            ├─────────────────────────────────────────────────────────────────┤
│            │                                                                 │
│            │  Keuangan                                  [+ Tambah Transaksi] │
│            │  ═════════                                                      │
│            │                                                                 │
│            │  Total Saldo: Rp 12.500.000                                     │
│            │                                                                 │
│            │  ┌────────────────┐ ┌────────────────┐                          │
│            │  │  💰 Kas        │ │  📆 Mingguan   │                          │
│            │  │  Assyukro      │ │                │                          │
│            │  │  ─────────────│ │  ─────────────│                          │
│            │  │  Rp 5.000.000 │ │  Rp 2.000.000 │                          │
│            │  │  [Lihat →]    │ │  [Lihat →]    │                          │
│            │  └────────────────┘ └────────────────┘                          │
│            │                                                                 │
│            │  ┌────────────────┐ ┌────────────────┐                          │
│            │  │  📅 Bulanan    │ │  🌙 Idul Fitri │                          │
│            │  │                │ │                │                          │
│            │  │  ─────────────│ │  ─────────────│                          │
│            │  │  Rp 3.500.000 │ │  Rp 2.000.000 │                          │
│            │  │  [Lihat →]    │ │  [Lihat →]    │                          │
│            │  └────────────────┘ └────────────────┘                          │
│            │                                                                 │
│            │  ┌───────────────────────────────────────────────────────────┐  │
│            │  │  Transaksi Terbaru                               Lihat →  │  │
│            │  ├───────────────────────────────────────────────────────────┤  │
│            │  │  25 Des │ Kas Assyukro │ Iuran Rapat  │ +Rp 500.000       │  │
│            │  │  24 Des │ Mingguan     │ Konsumsi     │ -Rp 200.000       │  │
│            │  │  23 Des │ Bulanan      │ Donasi       │ +Rp 1.000.000     │  │
│            │  └───────────────────────────────────────────────────────────┘  │
│            │                                                                 │
└────────────┴─────────────────────────────────────────────────────────────────┘
```

### 6.7 Admin - Detail Kategori Keuangan

```
┌──────────────────────────────────────────────────────────────────────────────┐
│  SIDEBAR   │  HEADER                                                         │
│            ├─────────────────────────────────────────────────────────────────┤
│            │                                                                 │
│            │  ← Kembali                                                      │
│            │                                                                 │
│            │  Kas Assyukro                              [+ Tambah Transaksi] │
│            │  ═════════════                                                  │
│            │                                                                 │
│            │  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐               │
│            │  │   Saldo     │ │  Pemasukan  │ │ Pengeluaran │               │
│            │  │  Rp 5.000.000│ │ Rp 8.000.000│ │ Rp 3.000.000│               │
│            │  └─────────────┘ └─────────────┘ └─────────────┘               │
│            │                                                                 │
│            │  Filter:                                                        │
│            │  ┌────────────┐ ┌────────────┐ ┌────────────┐ ┌────────┐       │
│            │  │ Dari: [📅]│ │ Sampai:[📅]│ │ Jenis: [▼] │ │ Filter │       │
│            │  └────────────┘ └────────────┘ └────────────┘ └────────┘       │
│            │                                                                 │
│            │  ┌───────────────────────────────────────────────────────────┐  │
│            │  │ Tanggal  │ Jenis      │ Keterangan    │ Nominal    │ Aksi │  │
│            │  ├───────────────────────────────────────────────────────────┤  │
│            │  │ 25/12/24 │ ● Masuk    │ Iuran Rapat   │ +Rp 500.000│  ⋮   │  │
│            │  │ 20/12/24 │ ○ Keluar   │ ATK           │ -Rp 150.000│  ⋮   │  │
│            │  │ 15/12/24 │ ● Masuk    │ Donasi        │+Rp 1.000.000│  ⋮  │  │
│            │  │ 10/12/24 │ ○ Keluar   │ Transport     │ -Rp 100.000│  ⋮   │  │
│            │  ├───────────────────────────────────────────────────────────┤  │
│            │  │  ◄ Prev    1  2  3  ...  5    Next ►                      │  │
│            │  └───────────────────────────────────────────────────────────┘  │
│            │                                                                 │
└────────────┴─────────────────────────────────────────────────────────────────┘
```

### 6.8 Admin - Kegiatan

```
┌──────────────────────────────────────────────────────────────────────────────┐
│  SIDEBAR   │  HEADER                                                         │
│            ├─────────────────────────────────────────────────────────────────┤
│            │                                                                 │
│            │  Kegiatan                                  [+ Tambah Kegiatan]  │
│            │  ═════════                                                      │
│            │                                                                 │
│            │  Filter: [Semua ▼] [Akan Datang] [Selesai]                      │
│            │                                                                 │
│            │  ┌───────────────────────────────────────────────────────────┐  │
│            │  │ 📅                                                        │  │
│            │  │ Rapat Bulanan Desember                    ○ Akan Datang   │  │
│            │  │ ─────────────────────────────────────────────────────     │  │
│            │  │ 📆 28 Desember 2024  ⏰ 19:00 - 21:00                      │  │
│            │  │ 📍 Masjid Al-Ikhlas                                       │  │
│            │  │                                                           │  │
│            │  │ Rapat evaluasi kegiatan bulan Desember dan...             │  │
│            │  │                                                           │  │
│            │  │ [Lihat Detail] [Edit] [Hapus]                             │  │
│            │  └───────────────────────────────────────────────────────────┘  │
│            │                                                                 │
│            │  ┌───────────────────────────────────────────────────────────┐  │
│            │  │ 📅                                                        │  │
│            │  │ Bakti Sosial                              ○ Akan Datang   │  │
│            │  │ ─────────────────────────────────────────────────────     │  │
│            │  │ 📆 02 Januari 2025  ⏰ 08:00 - 12:00                       │  │
│            │  │ 📍 Desa Sukamaju                                          │  │
│            │  │                                                           │  │
│            │  │ Kegiatan bakti sosial bersama warga...                    │  │
│            │  │                                                           │  │
│            │  │ [Lihat Detail] [Edit] [Hapus]                             │  │
│            │  └───────────────────────────────────────────────────────────┘  │
│            │                                                                 │
└────────────┴─────────────────────────────────────────────────────────────────┘
```

### 6.9 Member Dashboard

```
┌──────────────────────────────────────────────────────────────────────────────┐
│  ┌─────────────┐  ┌────────────────────────────────────────────────────────┐ │
│  │             │  │  HEADER                               👤 Member Name ▼ │ │
│  │  SIDEBAR    │  ├────────────────────────────────────────────────────────┤ │
│  │             │  │                                                        │ │
│  │  🏛️ PADRP   │  │  Selamat Datang, Ahmad!                                │ │
│  │             │  │  ═══════════════════════                               │ │
│  │  ─────────  │  │                                                        │ │
│  │             │  │  ┌──────────────────┐  ┌──────────────────┐            │ │
│  │  📊 Dashboard│  │  │  📅 Kegiatan     │  │  💰 Total Saldo  │            │ │
│  │             │  │  │  Mendatang       │  │                  │            │ │
│  │  📅 Kegiatan│  │  │  ───────────     │  │  ───────────     │            │ │
│  │             │  │  │      3           │  │  Rp 12.500.000   │            │ │
│  │  💰 Keuangan│  │  └──────────────────┘  └──────────────────┘            │ │
│  │             │  │                                                        │ │
│  │  👤 Profil  │  │  ┌─────────────────────────────────────────────────┐   │ │
│  │             │  │  │  Kegiatan Mendatang                             │   │ │
│  │  ─────────  │  │  ├─────────────────────────────────────────────────┤   │ │
│  │             │  │  │  📌 Rapat Bulanan                               │   │ │
│  │  🚪 Logout  │  │  │     28 Des 2024 • 19:00 • Masjid Al-Ikhlas      │   │ │
│  │             │  │  │                                                 │   │ │
│  │             │  │  │  📌 Bakti Sosial                                │   │ │
│  │             │  │  │     02 Jan 2025 • 08:00 • Desa Sukamaju         │   │ │
│  │             │  │  │                                                 │   │ │
│  │             │  │  │  [Lihat Semua Kegiatan →]                       │   │ │
│  │             │  │  └─────────────────────────────────────────────────┘   │ │
│  │             │  │                                                        │ │
│  │             │  │  ┌─────────────────────────────────────────────────┐   │ │
│  │             │  │  │  Ringkasan Keuangan                             │   │ │
│  │             │  │  ├─────────────────────────────────────────────────┤   │ │
│  │             │  │  │  Kas Assyukro    ████████████░░  Rp 5.000.000   │   │ │
│  │             │  │  │  Rutin Mingguan  ████░░░░░░░░░░  Rp 2.000.000   │   │ │
│  │             │  │  │  Rutin Bulanan   ██████░░░░░░░░  Rp 3.500.000   │   │ │
│  │             │  │  │  Idul Fitri      ████░░░░░░░░░░  Rp 2.000.000   │   │ │
│  │             │  │  │                                                 │   │ │
│  │             │  │  │  [Lihat Detail Keuangan →]                      │   │ │
│  │             │  │  └─────────────────────────────────────────────────┘   │ │
│  │             │  │                                                        │ │
│  └─────────────┘  └────────────────────────────────────────────────────────┘ │
└──────────────────────────────────────────────────────────────────────────────┘
```

---

## 7. Responsive Breakpoints

```
Mobile:     < 640px   (sm)  - Single column, collapsed sidebar
Tablet:     640-1024px (md) - Collapsible sidebar
Desktop:    > 1024px  (lg)  - Full sidebar, multi-column
```

### 7.1 Mobile Adaptations

- Sidebar menjadi hamburger menu
- Cards stack vertically
- Tables menjadi card-based list
- Simplified navigation
- Touch-friendly buttons (min 44px tap target)

---

## 8. Micro-interactions

### 8.1 Hover Effects

- Buttons: Slight color change + subtle shadow
- Cards: Slight elevation (shadow increase)
- Table rows: Light background highlight
- Links: Color change + underline

### 8.2 Transitions

- All: 150-200ms ease-in-out
- Modals: Fade in + scale up
- Sidebar: Slide in from left
- Dropdowns: Fade in + slide down
- Alerts: Slide in from top

### 8.3 Loading States

- Buttons: Loading spinner + disabled state
- Tables: Skeleton loading
- Pages: Progress bar at top

### 8.4 Feedback

- Form submission: Button loading → Success toast
- Error: Red border on input + error message
- Delete: Confirmation modal → Success toast
- Status change: Immediate visual update + toast

---

## 9. Accessibility Guidelines

1. **Color Contrast:** Minimum 4.5:1 for normal text
2. **Focus States:** Visible focus rings on all interactive elements
3. **Alt Text:** All meaningful images have alt text
4. **Form Labels:** All inputs have associated labels
5. **Error Messages:** Clear, descriptive error messages
6. **Keyboard Navigation:** All functions accessible via keyboard
7. **Screen Reader:** Proper ARIA labels and semantic HTML

---

**Document Version:** 1.0  
**Last Updated:** 25 Desember 2024

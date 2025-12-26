# 📖 Panduan Pengguna - PADRP ASSYUKRO

Panduan lengkap cara menggunakan aplikasi PADRP ASSYUKRO untuk Admin dan Anggota.

---

## 📋 Daftar Isi

1. [Akses Aplikasi](#-akses-aplikasi)
2. [Panduan Admin](#-panduan-admin)
3. [Panduan Anggota](#-panduan-anggota)
4. [FAQ](#-faq)

---

## 🌐 Akses Aplikasi

### URL Aplikasi

-   **Development**: http://localhost:8000
-   **Production**: [URL Production Anda]

### Login

1. Buka halaman utama aplikasi
2. Klik tombol **"Masuk"** di navbar kanan atas
3. Masukkan email dan password
4. Klik **"Masuk"**

### Registrasi Anggota Baru

1. Buka halaman utama aplikasi
2. Klik tombol **"Daftar Sekarang"**
3. Isi formulir pendaftaran:
    - Nama lengkap
    - Email
    - Nomor telepon
    - Jenis kelamin
    - Tanggal lahir
    - Alamat lengkap
    - Password
4. Klik **"Daftar"**
5. Tunggu persetujuan dari Admin

---

## 👨‍💼 Panduan Admin

### Dashboard Admin

Setelah login sebagai Admin, Anda akan melihat dashboard dengan:

-   **Statistik**: Total anggota, kegiatan, pemasukan, pengeluaran
-   **Grafik Keuangan**: Visualisasi trend keuangan
-   **Aktivitas Terbaru**: Log aktivitas terkini

### 1. Manajemen Anggota

#### Melihat Daftar Anggota

1. Klik menu **"Anggota"** di sidebar
2. Lihat daftar semua anggota dengan status masing-masing

#### Menyetujui/Menolak Pendaftaran

1. Di halaman Anggota, cari anggota dengan status **"Menunggu Persetujuan"**
2. Klik ikon **mata** untuk melihat detail
3. Klik **"Setujui"** atau **"Tolak"**
4. Jika menolak, masukkan alasan penolakan

#### Mengedit Data Anggota

1. Klik ikon **pensil** pada anggota yang ingin diedit
2. Ubah data yang diperlukan
3. Klik **"Simpan Perubahan"**

#### Menghapus Anggota

1. Klik ikon **tempat sampah** pada anggota
2. Konfirmasi penghapusan

#### Filter dan Pencarian

-   Gunakan dropdown **"Semua Status"** untuk filter berdasarkan status
-   Gunakan kotak pencarian untuk mencari berdasarkan nama/email

---

### 2. Manajemen Keuangan

#### Kategori Keuangan

Aplikasi memiliki 4 kategori keuangan:

1. **Kas Assyukro** - Kas utama organisasi
2. **Rutinan Mingguan** - Iuran rutin mingguan
3. **Rutinan Bulanan** - Iuran rutin bulanan
4. **Keuangan Idul Fitri** - Dana khusus Idul Fitri

#### Memilih Kategori

1. Klik menu **"Keuangan"** di sidebar
2. Klik salah satu kategori untuk melihat transaksi

#### Menambah Transaksi Baru

1. Pilih kategori keuangan
2. Klik tombol **"+ Tambah Transaksi"**
3. Isi formulir:
    - **Jenis**: Pemasukan atau Pengeluaran
    - **Jumlah**: Nominal dalam Rupiah (otomatis terformat)
    - **Tanggal**: Tanggal transaksi
    - **Keterangan**: Deskripsi transaksi
4. Klik **"Simpan Transaksi"**

#### Mengedit Transaksi

1. Klik ikon **pensil** pada transaksi
2. Ubah data yang diperlukan
3. Klik **"Simpan Perubahan"**

#### Menghapus Transaksi

1. Klik ikon **tempat sampah** pada transaksi
2. Konfirmasi penghapusan

#### Melihat Saldo

-   **Saldo** ditampilkan di bagian atas halaman kategori
-   Saldo = Total Pemasukan - Total Pengeluaran

---

### 3. Manajemen Kegiatan

#### Melihat Daftar Kegiatan

1. Klik menu **"Kegiatan"** di sidebar
2. Lihat semua kegiatan dalam format kartu

#### Urutan Tampilan Kegiatan

Kegiatan ditampilkan dengan urutan:

1. 🟡 **Sedang Berlangsung** (paling atas)
2. 🔵 **Akan Datang**
3. 🟢 **Selesai** (paling bawah)

#### Menambah Kegiatan Baru

1. Klik tombol **"+ Tambah Kegiatan"**
2. Isi formulir:
    - **Judul**: Nama kegiatan
    - **Deskripsi**: Penjelasan kegiatan
    - **Tanggal**: Tanggal pelaksanaan
    - **Waktu Mulai**: Jam mulai
    - **Waktu Selesai**: Jam selesai
    - **Lokasi**: Tempat pelaksanaan
3. Klik **"Simpan Kegiatan"**

#### Mengubah Status Kegiatan

1. Klik ikon **pensil** pada kegiatan
2. Ubah **Status** di dropdown:
    - Akan Datang
    - Sedang Berlangsung
    - Selesai
3. Klik **"Simpan Perubahan"**

#### Filter Berdasarkan Status

-   Gunakan dropdown **"Semua Status"** untuk filter

---

### 4. Profil Admin

#### Mengedit Profil

1. Klik menu **"Profil"** di sidebar
2. Ubah data yang diperlukan
3. Klik **"Simpan Perubahan"**

#### Mengubah Password

1. Di halaman Profil, scroll ke bagian **"Ubah Password"**
2. Masukkan password lama
3. Masukkan password baru (min. 8 karakter)
4. Konfirmasi password baru
5. Klik **"Ubah Password"**

---

## 👤 Panduan Anggota

### Dashboard Anggota

Setelah login sebagai Anggota, Anda akan melihat dashboard dengan:

-   **Statistik**: Jumlah kegiatan, ringkasan keuangan
-   **Kegiatan Mendatang**: 3 kegiatan terdekat
-   **Aksi Cepat**: Shortcut ke fitur utama

### 1. Melihat Kegiatan

1. Klik menu **"Kegiatan"** di sidebar
2. Lihat daftar semua kegiatan organisasi
3. Gunakan tab filter:

    - **Semua**: Semua kegiatan
    - **Sedang Berlangsung**: Kegiatan hari ini
    - **Akan Datang**: Kegiatan mendatang
    - **Selesai**: Kegiatan yang sudah lewat

4. Klik kegiatan untuk melihat detail lengkap

### 2. Melihat Laporan Keuangan

Anggota dapat melihat laporan keuangan organisasi (read-only):

1. Klik menu **"Keuangan"** di sidebar
2. Pilih kategori keuangan yang ingin dilihat
3. Lihat daftar transaksi dan saldo

> 💡 **Catatan**: Anggota hanya bisa melihat, tidak bisa menambah/edit/hapus transaksi.

### 3. Profil Anggota

#### Melihat & Mengedit Profil

1. Klik menu **"Profil Saya"** di sidebar
2. Lihat informasi profil Anda
3. Klik **"Edit Profil"** untuk mengubah data
4. Klik **"Simpan Perubahan"**

#### Mengubah Password

1. Di halaman Profil, klik **"Ubah Password"**
2. Ikuti langkah yang sama seperti Admin

---

## ❓ FAQ

### Umum

**Q: Bagaimana cara menghubungi admin jika ada masalah?**
A: Hubungi admin melalui kontak yang tersedia di organisasi.

**Q: Bisakah saya mengakses dari HP?**
A: Ya, aplikasi responsive dan bisa diakses dari browser HP.

### Login & Registrasi

**Q: Saya lupa password, bagaimana cara reset?**
A: Hubungi admin untuk mereset password Anda.

**Q: Sudah daftar tapi tidak bisa login?**
A: Tunggu persetujuan admin. Status pendaftaran bisa dilihat saat mencoba login.

**Q: Berapa lama proses persetujuan pendaftaran?**
A: Tergantung kebijakan admin, biasanya 1-3 hari kerja.

### Keuangan

**Q: Mengapa saya tidak bisa menambah transaksi?**
A: Hanya Admin yang bisa mengelola transaksi. Anggota hanya bisa melihat.

**Q: Apakah data keuangan real-time?**
A: Ya, data selalu update sesuai input admin.

### Kegiatan

**Q: Bagaimana cara mendaftar kegiatan?**
A: Saat ini pendaftaran kegiatan dilakukan secara offline. Hubungi admin.

**Q: Kegiatan tidak muncul di filter "Sedang Berlangsung"?**
A: Status kegiatan diatur manual oleh admin. Hubungi admin jika ada kesalahan.

---

## 🆘 Bantuan Teknis

Jika mengalami kendala teknis:

1. Refresh halaman (Ctrl+F5 / Cmd+Shift+R)
2. Clear cache browser
3. Coba browser lain
4. Hubungi admin/developer

---

**© 2025 PADRP ASSYUKRO - All Rights Reserved**

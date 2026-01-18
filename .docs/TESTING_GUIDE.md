# Dokumen Pengujian Sistem Penuh (Full System Test Suite)

Dokumen ini berisi rangkaian skenario pengujian (Test Cases) untuk memvalidasi seluruh fitur Sistem Informasi Warga Dusun Kauman, sesuai dengan spesifikasi kebutuhan (Requirements) terbaru.

**Tujuan:** Memastikan sistem berjalan 100% sesuai spesifikasi UI/UX (Clean, No Emoji) dan Fungsional (Logic, Database).

---

## 1. Modul Autentikasi & Registrasi

**Aktor:** Pengunjung (Guest), Warga

| ID          | Skenario              | Langkah Pengujian                                | Data Input (Contoh)                         | Ekspektasi Hasil (Pass Criteria)                                                                     |
| :---------- | :-------------------- | :----------------------------------------------- | :------------------------------------------ | :--------------------------------------------------------------------------------------------------- |
| **AUTH-01** | **Registrasi Warga**  | Buka `/register`. Isi form lengkap.              | Nama: Budi<br>RT: RT 03<br>RW: RW 01        | ✅ Berhasil redirect ke Dashboard Warga.<br>✅ Data tersimpan di database dengan `rt_id` yang benar. |
| **AUTH-02** | **Validasi Register** | Buka `/register`. Kosongkan field wajib. Submit. | Kosong                                      | ✅ Pesan error muncul di bawah field terkait.<br>✅ Tidak ada error system (500).                    |
| **AUTH-03** | **Login Warga**       | Buka `/login`. Masukkan kredensial warga.        | Email: ahmad@gmail.com<br>Pass: password123 | ✅ Masuk ke `/warga/dashboard`.<br>✅ Header menampilkan nama user.                                  |
| **AUTH-04** | **Login Admin**       | Buka `/login`. Masukkan kredensial admin.        | Email: admin@kauman.id<br>Pass: password123 | ✅ Masuk ke `/admin/dashboard`.<br>✅ Menu Admin lengkap terlihat.                                   |
| **AUTH-05** | **Logout**            | Klik menu profil -> Keluar.                      | -                                           | ✅ Redirect ke halaman Login.<br>✅ Session terhapus (tidak bisa 'Back').                            |

---

## 2. Modul Bank Sampah (Core Feature)

**Aktor:** Admin, Warga
**Fokus UI:** Bersih dari Emoji.

### A. Manajemen Jenis Sampah (Admin)

| ID        | Skenario         | Langkah Pengujian                      | Input Data                                           | Ekspektasi Hasil                                                                          |
| :-------- | :--------------- | :------------------------------------- | :--------------------------------------------------- | :---------------------------------------------------------------------------------------- |
| **BS-01** | **Tambah Jenis** | Admin: Menu `Jenis Sampah` -> Tambah.  | Nama: Kardus<br>Harga: 2000<br>Satuan: kg (Dropdown) | ✅ Data muncul di tabel.<br>✅ Kolom "Icon" tidak ada (sudah dihapus).                    |
| **BS-02** | **Edit Jenis**   | Admin: Klik Edit pada salah satu item. | Ubah Harga: 2500                                     | ✅ Modal Edit muncul (Background blur, bukan hitam).<br>✅ Data terupdate setelah simpan. |
| **BS-03** | **Hapus Jenis**  | Admin: Klik Hapus -> Konfirmasi.       | -                                                    | ✅ Data hilang dari tabel.                                                                |

### B. Transaksi Setoran (Admin & Warga)

| ID        | Skenario            | Langkah Pengujian                                            | Input Data                                  | Ekspektasi Hasil                                                                                      |
| :-------- | :------------------ | :----------------------------------------------------------- | :------------------------------------------ | :---------------------------------------------------------------------------------------------------- |
| **BS-04** | **Catat Setoran**   | Admin: Menu `Setoran` -> Catat Baru.<br>Pilih Warga & Jenis. | Warga: Budi<br>Jenis: Plastik<br>Berat: 5kg | ✅ Transaksi tersimpan.<br>✅ Saldo Warga bertambah (5 x Harga).<br>✅ Layout form bersih (No Emoji). |
| **BS-05** | **Lihat Saldo**     | Warga: Menu `Bank Sampah` (Dashboard).                       | -                                           | ✅ Tampil Saldo Total yang benar.<br>✅ Tampilan kartu saldo bersih (No Emoji besar 💰).              |
| **BS-06** | **Riwayat Setoran** | Warga: Menu `Bank Sampah` -> Tabel Riwayat.                  | -                                           | ✅ Setoran yang baru dicatat Admin muncul di sini.<br>✅ Kolom Jumlah/Berat sesuai.                   |

### C. Penukaran Saldo (Redemption)

| ID        | Skenario          | Langkah Pengujian                        | Input Data                     | Ekspektasi Hasil                                                                                       |
| :-------- | :---------------- | :--------------------------------------- | :----------------------------- | :----------------------------------------------------------------------------------------------------- |
| **BS-07** | **Ajukan Tukar**  | Warga: Menu `Tukar Saldo`. Isi form.     | Jumlah: 15.000<br>Jenis: Tunai | ✅ Form tidak error.<br>✅ Prefix "Rp" di input jumlah tidak menabrak angka.<br>✅ Status: "Menunggu". |
| **BS-08** | **Setujui Tukar** | Admin: Menu `Penukaran`. Klik "Setujui". | -                              | ✅ Status berubah jadi "Selesai".<br>✅ Saldo Warga berkurang sesuai jumlah penukaran.                 |
| **BS-09** | **Tolak Tukar**   | Admin: Menu `Penukaran`. Klik "Tolak".   | -                              | ✅ Status berubah jadi "Ditolak".<br>✅ Saldo Warga KEMBALI (Refund) atau tidak terpotong.             |

---

## 3. Modul Keuangan RT (Transparansi)

**Aktor:** Admin, Warga

| ID         | Skenario            | Langkah Pengujian                                      | Input Data           | Ekspektasi Hasil                                                                                                                  |
| :--------- | :------------------ | :----------------------------------------------------- | :------------------- | :-------------------------------------------------------------------------------------------------------------------------------- |
| **FIN-01** | **Lihat Ringkasan** | Warga: Menu `Keuangan RT`.                             | -                    | ✅ Menampilkan Total Saldo, Pemasukan, Pengeluaran.<br>✅ Tidak ada emoji statis yang mengganggu.                                 |
| **FIN-02** | **Detail Kategori** | Warga: Klik Kategori "Iuran Warga".                    | -                    | ✅ Masuk halaman Detail.<br>✅ Tabel transaksi muncul.<br>✅ Kolom Jumlah formatnya `Rp 50.000` (TIDAK BOLEH `++Rp` atau `--Rp`). |
| **FIN-03** | **Filter Data**     | Warga: Di halaman Detail, filter "Bulan".              | Pilih Bulan: Januari | ✅ Data terfilter.<br>✅ Tombol **Reset** muncul sejajar dengan input tanggal.                                                    |
| **FIN-04** | **Input Transaksi** | Admin: Tambah data keuangan (via DB/Seeder sementara). | -                    | ✅ Data yang diinput Admin harus muncul realtime di dashboard Warga.                                                              |

---

## 4. Modul Kegiatan (Events)

**Aktor:** Admin, Warga

| ID         | Skenario         | Langkah Pengujian                         | Input Data | Ekspektasi Hasil                                                                                        |
| :--------- | :--------------- | :---------------------------------------- | :--------- | :------------------------------------------------------------------------------------------------------ |
| **EVT-01** | **Filter Event** | Warga: Menu `Kegiatan`. Klik "Mendatang". | -          | ✅ Hanya menampilkan event yang belum lewat tanggalnya.<br>✅ Tombol filter aktif berwarna Hijau solid. |
| **EVT-02** | **Detail Event** | Warga: Klik salah satu kartu kegiatan.    | -          | ✅ Masuk halaman detail.<br>✅ Informasi Waktu & Lokasi jelas (menggunakan Icon SVG).                   |

---

## 5. Modul Data Warga (Admin)

**Aktor:** Admin

| ID         | Skenario         | Langkah Pengujian                       | Input Data          | Ekspektasi Hasil                                                          |
| :--------- | :--------------- | :-------------------------------------- | :------------------ | :------------------------------------------------------------------------ |
| **RES-01** | **Lihat Daftar** | Admin: Menu `Data Warga`.               | -                   | ✅ Tabel daftar warga muncul dengan pagination.<br>✅ Kolom RT/RW sesuai. |
| **RES-02** | **Verifikasi**   | Admin: Menu `Warga Pending` (jika ada). | -                   | ✅ Admin bisa mengaktifkan warga yang baru daftar.                        |
| **RES-03** | **Edit Warga**   | Admin: Edit data warga.                 | Ubah No HP / Alamat | ✅ Perubahan tersimpan.                                                   |

---

## Cara Melaporkan Bug

Jika Anda menemukan fitur yang tidak sesuai dengan **Ekspektasi Hasil**, catat ID Test Case (misalnya: **BS-07 Gagal**) dan lampirkan screenshot.

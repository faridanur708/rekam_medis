# Sistem Informasi Rekam Medis Sederhana

Aplikasi web berbasis PHP dan MySQL untuk mengelola data pasien, dokter, obat, serta pencatatan riwayat rekam medis secara terintegrasi.

## Fitur Utama
* **Dashboard Interaktif:** Menampilkan ringkasan statistik jumlah pasien, dokter, obat, dan transaksi rekam medis dengan kartu navigasi cepat.
* **Manajemen Data Master (CRUD):** Pengelolaan data Pasien, Dokter, dan Obat dilengkapi fitur tambah, modal pop-up edit, serta konfirmasi hapus (SweetAlert2).
* **Transaksi Rekam Medis:** Pencatatan pemeriksaan pasien yang menghubungkan relasi tabel `pasien`, `dokter`, dan `obat` menggunakan *Foreign Key* dan query `SQL JOIN`.

## Struktur File
* `index.php` — Halaman utama dashboard statistik.
* `koneksi.php` — Konfigurasi koneksi database MySQL.
* `pasien.php` / `edit_pasien.php` — Manajemen data pasien.
* `dokter.php` / `edit_dokter.php` — Manajemen data dokter.
* `obat.php` / `edit_obat.php` — Manajemen data stok obat.
* `rekam_medis.php` / `tambah_rekam.php` — Data dan input riwayat rekam medis.
* `database.sql` — Struktur tabel dan relasi database MySQL.

## Cara Menjalankan
1. Impor file `database.sql` ke dalam phpMyAdmin atau MySQL server.
2. Sesuaikan pengaturan host, username, password, dan nama database pada file `koneksi.php`.
3. Jalankan proyek melalui web server lokal (XAMPP/Laragon/Code-Server) dengan mengakses `index.php`.

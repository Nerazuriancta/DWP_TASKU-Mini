# Jobsheet 12 — Integrasi Front-end dan Back-end TASKU-Mini

## Tujuan
Mengintegrasikan tampilan HTML/CSS/JavaScript dengan proses PHP dan database PostgreSQL sehingga fitur TASKU-Mini berjalan sebagai satu aplikasi.

## Bagian yang terintegrasi
- **Dashboard (`index.php`)**: menampilkan jumlah seluruh tugas, tugas berdasarkan status, dan deadline terdekat yang belum selesai.
- **Tugas (`tugas/`)**: menampilkan, mencari, memfilter, menambah, mengedit, dan menghapus tugas.
- **Mata kuliah (`matkul/`)**: menampilkan, menambah, mengedit, dan menghapus data mata kuliah.
- **Autentikasi (`auth/`)**: registrasi, login, dan logout.
- **Tampilan (`assets/style.css`)**: desain responsif untuk desktop dan perangkat seluler.
- **Interaksi (`assets/app.js`)**: pencarian/filter tugas dan menu hamburger.
- **Database (`includes/koneksi.php`)**: koneksi PDO ke PostgreSQL. Konfigurasi koneksi dari Jobsheet 11 tetap dipertahankan.
- **Validasi dan keamanan**: validasi input pada proses PHP, prepared statements, output escaping, pembatasan halaman CRUD untuk pengguna login, serta token CSRF pada form.

## Alur data
1. Pengguna membuka halaman melalui browser.
2. PHP mengambil atau mengirim data menggunakan PDO ke PostgreSQL.
3. Data yang diterima ditampilkan pada halaman menggunakan HTML.
4. Form tambah/edit/hapus mengirim data ke file `proses_*.php` atau `hapus.php`.
5. PHP memvalidasi input dan token CSRF, menyimpan perubahan ke database, lalu mengarahkan pengguna kembali dengan pesan status.

## Cara menjalankan
1. Pastikan PostgreSQL aktif dan database TASKU-Mini yang digunakan pada Jobsheet 11 sudah tersedia.
2. Pastikan variabel lingkungan `DB_HOST`, `DB_NAME`, `DB_USER`, dan `DB_PASSWORD` (opsional `DB_PORT`, default `5432`) sudah diatur sesuai konfigurasi koneksi yang dipakai.
3. Jalankan terminal dari folder `Jobsheet-12`, lalu jalankan:
   ```powershell
   php -S localhost:8000
   ```
4. Buka `http://localhost:8000`.
5. Jika tabel belum tersedia, jalankan skrip `sql/01_tasku.sql` dan `sql/02_user.sql` pada database yang benar. Jangan membuat ulang database jika data Jobsheet 11 ingin tetap digunakan.
6. Buat akun melalui `http://localhost:8000/auth/register.php`, login, lalu uji fitur tugas dan mata kuliah.

## Pengujian yang disarankan
- Dashboard menampilkan jumlah data sesuai database.
- Tambah tugas dengan data valid, lalu pastikan data muncul pada daftar tugas.
- Edit tugas, lalu pastikan perubahan tersimpan.
- Hapus tugas, lalu pastikan data hilang.
- Cari tugas dan gunakan filter mata kuliah/status.
- Coba membuka halaman tambah/edit tanpa login; aplikasi harus mengarahkan ke halaman login.
- Coba submit form tanpa token CSRF; permintaan harus ditolak.
- Buka halaman di ukuran layar kecil dan pastikan menu hamburger berfungsi.

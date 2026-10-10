## Nama     : Nerazuriancta Purnama Syah Putri
## NIM      : 254107020117
## Kelas    : TI-2D

# Wireframe & User Flow - SIMPUS-Mini

Halaman yang sudah ada pada SIMPUS-Mini, yaitu Beranda, Daftar Buku, Tambah Buku, Daftar Anggota, dan Tambah Anggota, belum mencakup fitur Login, Dahboard Petugas, Peminjaman, Pengembalian, dan Riwayat Peminjaman. Oleh karena itu, pada Jobsheet 4 dibuat rancangan user flow dan wireframe sebagai acuan pengembangan fitur pada Jobsheet berikutnya.

## Aktor
- Tamu      : dapat melihat Beranda dan Daftar Buku tanpa melakukan login.
- Petugas   : harus melakukan login untuk mengakses fitur pengelolaan data dan transaksi perpustakaan.

## User Flow - Peminjaman Buku
```
[Petugas Login] -> [ Dashboard ] -> [Pilih Menu "Peminjaman Baru"]
    -> [Pilih Anggota] -> [Pilih Buku]
    -> [Cek Stok Buku]
    -> [Simpan Peminjaman]
    -> [Stok Buku Berkurang]
    -> [Kembali ke Dashboard]
```

Jika stok buku habis, buku tidak dapat dipilih untuk melakukan peminjaman.

## User Flow - Pengembalian Buku
```
[ Dashboard ] -> [Menu "Pengembalian"]
    -> [Cari Transaksi Aktif]
    -> [Pilih Data Peminjaman]
    -> [Tandai "Dikembalikan"]
    -> [Stok Buku Bertambah]
    -> [Kembali ke Dashboard]
```

## Wireframe: Halaman Login
```
+-----------------------------------------------+
|                 SIMPUS-Mini                   |
|-----------------------------------------------|
|                                               |
|                Login Petugas                  |
|                                               |
|                                               |
|       Username    : [ _________________ ]     |
|       Password    : [ _________________ ]     |
|                                               |
|                                               |
|                   [ Masuk ]                   |
|                                               |
|                                               |
|       Belum punya akun? Daftar di sini        |
+-----------------------------------------------+
```

Halaman Login digunakan oleh petugas untuk masuk ke dalam sistem dan mengakses fitur pengelolaan perpustakaan.
### Komponen Halaman Login
| Komponen | Fungsi |
|---|---|
| Logo/Nama SIMPUS-Mini | Menampilkan identitas aplikasi |
| Judul Login Petugas | Menunjukkan tujuan halaman |
| Input Username | Digunakan untuk memasukkan username petugas |
| Input Password | Digunakan untuk memasukkan password petugas |
| Tombol Masuk | Digunakan untuk melakukan proses login |
| Teks "Belum punya akun?" | Membrikan informasi kepada pengguna yang belum memiliki akun |
| Tautan "Daftar di sini" | Mengarahkan pengguna ke halaman pendaftaran akun |

## Wireframe: Dashboard Petugas
```
+----------------------------------------------------+
| SIMPUS-Mini | Buku | Anggota | Peminjaman | Logout |
|----------------------------------------------------|
|                                                    |
|    [ Total Buku ] [ Total Anggota ] [ Dipinjam ]   |
|                                                    |
|    Aksi Cepat:                                     |
|                                                    |
|    [ + Peminjaman Baru ] [ + Pengembalian ]        |
|                                                    |
|    Transaksi Terbaru                               |
|    -------------------------------------------     |
|     Anggota | Buku | Tanggal Pinjam | Status       |
|                                                    |
+----------------------------------------------------+
```

Dashboard menampilkan informasi ringkasan perpustakaan, shortcut untuk transaksi, serta daftar transaksi terbaru.
### Komponen Dashboard Petugas
| Komponen | Fungsi |
|---|---|
| Header/Navbar | Menampilkan identitas aplikasi dan menu navigasi |
| Menu Buku | Mengakses halaman pengelolaan buku |
| Menu Anggota | Mengakses halaman pengelolaan anggota |
| Menu Peminjaman | Mengakses fitur transaksi peminjaman |
| Tombol Logout | Digunakan untuk keluar dari akun petugas |
| Kartu Total Buku | Menampilkan jumlah seluruh buku |
| Kartu Total Anggota | Menampilkan jumlah anggota anggota |
| Kartu Sedang Dipinjam | Menampilkan jumlah buku yang sedang dipinjam |
| Tombol Peminjaman Baru | Shortcut menuju form peminjaman |
| Tombol Pengembalian | Shortcut menuju halaman pengembalian |
| Tabel Transaksi Terbaru | Menampilkan transaksi peminjaman terbaru |

## Wireframe: Form Peminjaman
```
+----------------------------------------------------+
|               Form Peminjaman Buku                 |
|----------------------------------------------------|
|                                                    |
|      Anggota    : [ Pilih Anggota     v ]          |
|      Anggota    : [ Pilih Anggota     v ]          |
|                                                    |
|      Tanggal Pinjam   : [Hari Ini]                 |
|                                                    |
|               [ Simpan Peminjaman ]                |
|                                                    |
+----------------------------------------------------+
```

Form ini digunakan petugas untuk mencatat transaksi peminjaman buku oleh anggota.
### Komponen Form Peminjaman
| Komponen | Fungsi |
|---|---|
| Judul Halaman | Menunjukkan halaman Form Peminjaman Buku |
| Dropdown Anggota | Digunakan untuk memilih anggota yang meminjam buku |
| Dropdown Buku | Digunakan untuk memilih buku yang akan dipinjam |
| Informasi Stok |Menampilkan ketersediaan buku yang dipilih |
| Tanggal Pinjam | Menampilkan tanggal transaksi peminjaman |
| Tombol Simpan Peminjaman | Menyimpan data transaksi peminjaman |

## Wireframe: Form Pengembalian
```
+----------------------------------------------------+
|                 Pengembalian Buku                  |
|----------------------------------------------------|
|                                                    |
| Cari transaksi aktif:                              |
| [ Nama Anggota / Judul Buku _______________ ]      |
|                                                    |
| Anggota | Buku | Tanggal Pinjam | Status           |
| -------------------------------------------        |
| Siti    | Laskar Pelangi  | 01/07 | [ Kembali ]    |
|                                                    |
+----------------------------------------------------+
```

Halaman ini digunakan untuk mencari transaksi peminjaman yang masih aktif dan meproses pengembalian buku.
### Komponen Form Pengembalian
| Komponen | Buku |
|---|---|
| Judul Halaman | Menunjukkan halaman Pengembalian Buku |
| Kolom Pencarian | Digunakan untuk mencari transaksi aktif berdasarkan anggota atau buku |
| Tabel Transaksi Aktif | Menampilkan data buku yang masih dipinjam |
| Kolom Anggota | Menampilkan nama anggota yang meminjam |
| Kolom Buku | Menampilkan judul buku yang dipinjam |
| Kolom Tanggal Pinjam | Menampilkan tanggal buku dipinjam |
| Tombol Kembalikan | Digunakan untuk memproses pengembalian buku |

## Wireframe: Riwayat Peminjaman per Anggita
```
+----------------------------------------------------+
|         Riwayat Peminjaman - Nama Anggota          |
|----------------------------------------------------|
|                                                    |
| Buku           | Peminjaman | Kembali | Status     |
| -------------------------------------------------- |
|                                                    |
| Laskar Pelangi | 01/07      | 10/07   | Selesai    |
| Bumi Manusia   | 15/07      | -       | Dipinjam   |
| -------------------------------------------------- |
|                                                    |
+----------------------------------------------------+
```

Halaman ini menampilkan riwayat transaksi peminjaman yang pernah dilakukan oleh seorang anggota.
### Komponen Riwayat Peminjaman
| Komponen | Fungsi |
|---|---|
|Judul Halaman | Menampilkan nama halaman dan anggota yang dipilih |
| Informasi Anggota | Menunjukkan anggota yang riwayatnya sedang dilihat |
| Tabel Riwayat | Menampilkan seluruh riwayat peminjaman anggota |
| Kolom Buku | Menampilkan judul buku yang pernah dipinjam |
| Kolom Tanggal Pinjam | Menampilkan tanggal peminjaman |
| Kolom Tanggal Kembali | Menampilkan tanggal pengembalian buku |
| Kolom Status | Menampilkan status peminjaman, seperti Dipinjam atau Selesai |

## Konsistensi dengan Desain yang Sudah Berjalan
- Warna utama menggunakan warna biru yang telah digunakan pada desain SIMPUS-Mini sebelumnya.
- Header dan navbar tetap menggunakan gaya yang sama agar seluruh halaman terlihat sebagai satu sistem.
- Tampilan tabel mengikuti desain halaman Daftar Buku dan Daftar Anggota.
- Kartu ringkasan pada Dashboard mengikuti gaya kartu statistik pada halaman Beranda.
- Form Peminjaman dan Pengembalian mengikuti gaya form Tambah Buku dan Tambah Anggota.
- Pada tampilan mobile, navigasi menggunakan ikon hamburger seperti yang telah dibuat pada Jobsheet 3.

## Edge Case
Beberapa kondisi yang perlu diperhatikan pada implementasi selanjutnya adalah:
- Buku dengan stok habis tidak dapat dipilih untuk peminjaman.
- Anggota yang memiliki tunggakan perlu mendapatkan validasi sebelum melakukan peminjaman.
- Transaksi pengembalian hanya dapat dilakukan pada data peminjaman yang masih aktif.

## Kesimpulan
Jobsheet 4 berfokus pada perancangan UI/UX SIMPUS-Mini sebelum fitur interaktif dan database diimplementasikan. User flow digunakan untuk menggambarkan alur peminjaman dan pengembalian buku, sedangkan wireframe digunakan sebagai rancangan awal struktur setiap halaman. Setiap wireframe terdiri dari komponen-komponen yang dirancang sesuai dengan fungsi halaman. Rancangan ini akan menjadi acuan dalam pengembangan fitur Login, Dashboard Petugas, Peminjaman, Pengembalian, dan Riwayat Peminjaman pada Jobsheet berikutnya.
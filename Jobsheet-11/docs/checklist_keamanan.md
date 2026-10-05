# Checklist Keamanan TASKU-Mini — Jobsheet 11

## Tujuan
Melakukan hardening pada aplikasi TASKU-Mini berdasarkan prinsip keamanan web dasar tanpa menambah fitur baru.

| No | Pemeriksaan | Before | After | Bukti/Uji |
|---|---|---|---|---|
| 1 | SQL Injection pada login | Query login perlu diaudit | Login memakai PDO prepared statement + parameter `:username` | Uji username `' OR '1'='1` tidak dapat login |
| 2 | SQL Injection pada data tugas | Query database masih menggunakan `query()` untuk beberapa SELECT statis | Seluruh query aplikasi Jobsheet-11 memakai `prepare()` dan `execute()` | Tidak ada input user yang digabung langsung ke SQL |
| 3 | XSS pada nama tugas | Beberapa output belum melalui helper terpusat | Semua output data dinamis memakai `e()` → `htmlspecialchars()` | Simpan `<script>alert(1)</script>` sebagai nama tugas; script tidak dijalankan |
| 4 | XSS pada mata kuliah/dosen/kelas | Output hanya sebagian di-escape | Output tabel dan data form di-escape | Script ditampilkan sebagai teks, bukan dieksekusi |
| 5 | CSRF form hapus | Form POST belum mempunyai token | Form hapus memiliki hidden `csrf_token` dan diverifikasi dengan `hash_equals()` | Request tanpa token/ token salah menghasilkan HTTP 403 |
| 6 | CSRF form edit | Belum ada token | Form edit memiliki hidden `csrf_token` dan diverifikasi | Token salah ditolak |
| 7 | CSRF form tambah | Belum dilindungi | Form tambah memakai token session | Token salah ditolak |
| 8 | Validasi ID | ID dikonversi secara umum | ID memakai `FILTER_VALIDATE_INT` dan batas > 0 | ID bukan angka ditolak |
| 9 | Validasi panjang string | Belum menyeluruh | Nama tugas 150, matkul 100, dosen 100, kelas 20, dll. | Input melebihi batas ditolak |
| 10 | Whitelist pilihan | Nilai status/prioritas dapat dikirim manual | Status dan prioritas hanya menerima nilai yang ditentukan | Nilai lain ditolak server |
| 11 | Session fixation | Sudah tersedia di Jobsheet 10, tetapi perlu dipastikan | `session_regenerate_id(true)` setelah login berhasil | Session ID berubah setelah login |
| 12 | Password | Password disimpan sebagai hash | Tetap menggunakan `password_hash()` dan diverifikasi dengan `password_verify()` | Password tidak disimpan sebagai plaintext |

## Bukti uji SQL Injection

Input username:

```text
' OR '1'='1
```

Hasil yang diharapkan:

```text
Username atau password salah.
```

Aplikasi tidak masuk ke dashboard karena input diperlakukan sebagai nilai parameter, bukan bagian dari SQL.

## Bukti uji XSS

Input nama tugas:

```html
<script>alert(1)</script>
```

Hasil yang diharapkan:

```text
Kode script tampil sebagai teks/karakter HTML dan tidak menjalankan alert.
```

## Bukti uji CSRF

1. Login ke TASKU-Mini.
2. Buka halaman edit/hapus.
3. Kirim form normal → berhasil.
4. Hapus nilai `csrf_token` atau ubah nilainya melalui request manual.
5. Server harus mengembalikan:

```text
HTTP 403
Permintaan ditolak: token CSRF tidak valid atau kedaluwarsa.
```

## Kesimpulan

TASKU-Mini Jobsheet 11 telah diperkuat dengan:
- PDO prepared statement.
- Escaping output dengan `htmlspecialchars()`.
- CSRF token berbasis session.
- Validasi tipe dan panjang input.
- Whitelist untuk status dan prioritas.
- `session_regenerate_id(true)` setelah login.
- Password hashing dengan `password_hash()`.

Hardening ini tidak menambahkan modul baru pada TASKU-Mini; perubahan hanya berfokus pada keamanan aplikasi yang sudah ada.

### Catatan deployment Vercel

Session login menggunakan PHP session yang disimpan di PostgreSQL (`tasku_sessions`), bukan penyimpanan file lokal server. Hal ini menjaga session tetap terbaca ketika request berikutnya ditangani oleh instance serverless yang berbeda. `session_regenerate_id(true)` tetap dijalankan setelah login berhasil.

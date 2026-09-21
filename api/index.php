<?php
// Ubah working directory ke root proyek agar include relative path tetap bekerja
chdir(__DIR__ . '/..');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Menangani permintaan file statis (CSS, JS, Gambar)
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|svg)$/', $uri)) {
    return false;
}

// Router Mappings untuk TASKU-Mini
switch ($uri) {
    case '/':
    case '/index.php':
        require __DIR__ . '/../index.php';
        break;

    // Route untuk Module Tugas
    case '/tugas':
    case '/tugas/':
    case '/tugas/index.php':
        require __DIR__ . '/../tugas/index.php';
        break;
    case '/tugas/tambah.php':
        require __DIR__ . '/../tugas/tambah.php';
        break;
    case '/tugas/edit.php':
        require __DIR__ . '/../tugas/edit.php';
        break;
    case '/tugas/hapus.php':
        require __DIR__ . '/../tugas/hapus.php';
        break;

    // Route untuk Module Mata Kuliah
    case '/matkul':
    case '/matkul/':
    case '/matkul/index.php':
        require __DIR__ . '/../matkul/index.php';
        break;
    case '/matkul/tambah.php':
        require __DIR__ . '/../matkul/tambah.php';
        break;
    case '/matkul/edit.php':
        require __DIR__ . '/../matkul/edit.php';
        break;
    case '/matkul/hapus.php':
        require __DIR__ . '/../matkul/hapus.php';
        break;

    // Route untuk Tentang
    case '/tentang':
    case '/tentang/':
    case '/tentang/index.php':
        require __DIR__ . '/../tentang/index.php';
        break;

    // Default 404 jika route tidak ditemukan
    default:
        http_response_code(404);
        echo "404 - Halaman Tidak Ditemukan";
        break;
}
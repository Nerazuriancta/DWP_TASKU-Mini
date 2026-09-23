<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {

    case '/':
    case '/index.php':
        require __DIR__ . '/../index.php';
        break;

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

    case '/tentang':
    case '/tentang/':
    case '/tentang/index.php':
        require __DIR__ . '/../tentang/index.php';
        break;

    default:
        http_response_code(404);
        echo "404 - Halaman Tidak Ditemukan";
        break;
}
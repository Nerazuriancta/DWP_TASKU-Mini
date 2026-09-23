<?php

$path = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$path = urldecode($path);

$basePath = dirname(__DIR__);


/*
|--------------------------------------------------------------------------
| HELPER - SERVE STATIC FILE
|--------------------------------------------------------------------------
*/

function serveFile($file)
{
    if (!is_file($file)) {
        return false;
    }

    $extension = strtolower(
        pathinfo($file, PATHINFO_EXTENSION)
    );

    $mimeTypes = [
        'html'  => 'text/html; charset=UTF-8',
        'css'   => 'text/css; charset=UTF-8',
        'js'    => 'application/javascript; charset=UTF-8',

        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'webp'  => 'image/webp',
        'ico'   => 'image/x-icon',

        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf'
    ];

    if (isset($mimeTypes[$extension])) {

        header(
            'Content-Type: ' .
            $mimeTypes[$extension]
        );

        readfile($file);

        exit;
    }

    return false;
}


/*
|--------------------------------------------------------------------------
| ROOT WEBSITE
|--------------------------------------------------------------------------
*/

if ($path === '/' || $path === '') {

    $file = $basePath . '/index.html';

    if (is_file($file)) {

        header(
            'Content-Type: text/html; charset=UTF-8'
        );

        readfile($file);

        exit;
    }
}


/*
|--------------------------------------------------------------------------
| JOBSHEET 7
|--------------------------------------------------------------------------
*/

if (str_starts_with($path, '/Jobsheet-7')) {

    $relativePath = substr(
        $path,
        strlen('/Jobsheet-7')
    );

    if (
        $relativePath === '' ||
        $relativePath === '/'
    ) {
        $relativePath = '/index.php';
    }

    $file =
        $basePath .
        '/Jobsheet-7' .
        $relativePath;


    // Static files
    if (serveFile($file)) {
        exit;
    }


    // PHP
    if (
        strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'php' &&
        is_file($file)
    ) {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| JOBSHEET 8
|--------------------------------------------------------------------------
*/

if (str_starts_with($path, '/Jobsheet-8')) {

    $relativePath = substr(
        $path,
        strlen('/Jobsheet-8')
    );

    if (
        $relativePath === '' ||
        $relativePath === '/'
    ) {
        $relativePath = '/index.php';
    }

    $file =
        $basePath .
        '/Jobsheet-8' .
        $relativePath;


    // Static files
    if (serveFile($file)) {
        exit;
    }


    // PHP
    if (
        strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'php' &&
        is_file($file)
    ) {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| ROOT STATIC FILE
|--------------------------------------------------------------------------
*/

$file = $basePath . $path;

if (serveFile($file)) {
    exit;
}


/*
|--------------------------------------------------------------------------
| ROOT PHP
|--------------------------------------------------------------------------
*/

if (
    strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'php' &&
    is_file($file)
) {
    require $file;
    exit;
}


/*
|--------------------------------------------------------------------------
| 404
|--------------------------------------------------------------------------
*/

http_response_code(404);

echo "404 - Halaman tidak ditemukan.";
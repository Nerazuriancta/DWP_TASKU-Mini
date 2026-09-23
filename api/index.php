<?php

$path = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$path = urldecode($path);

$basePath = dirname(__DIR__);


/*
|--------------------------------------------------------------------------
| HELPER: SERVE FILE
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
        'css'  => 'text/css; charset=UTF-8',
        'js'   => 'application/javascript; charset=UTF-8',

        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'webp' => 'image/webp',
        'ico'  => 'image/x-icon',

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


    /*
    | Static assets
    */

    if (serveFile($file)) {
        exit;
    }


    /*
    | PHP
    */

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


    /*
    | Static assets
    */

    if (serveFile($file)) {
        exit;
    }


    /*
    | PHP
    */

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
| ROOT PHP
|--------------------------------------------------------------------------
*/

$file = $basePath . $path;

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
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/helpers.php';

csrf_verify();

require_once __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

/*
 * Mengambil halaman tujuan setelah login.
 * Jika tidak ada, kembali ke dashboard.
 */
$redirect = $_POST['redirect'] ?? '/Jobsheet-11/index.php';

/*
 * Validasi redirect agar tidak bisa diarahkan
 * ke website atau alamat lain.
 */
$redirectPath = parse_url($redirect, PHP_URL_PATH);

if (
    !$redirectPath ||
    str_starts_with($redirect, '//') ||
    preg_match('/^[a-z][a-z0-9+.-]*:/i', $redirect) ||
    strpos($redirectPath, '..') !== false
) {
    $redirect = '/Jobsheet-11/index.php';
}

/*
 * Validasi username dan password
 */
$stmt = $pdo->prepare(
    'SELECT * FROM users WHERE username = :username'
);

$stmt->execute([
    'username' => $username
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

/*
 * Login berhasil
 */
if ($user && password_verify($password, $user['password'])) {

    // Mencegah session fixation
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    // Kembali ke halaman yang sebelumnya ingin dibuka
    header('Location: ' . $redirect);
    exit;
}

/*
 * Login gagal
 */
$_SESSION['flash'] = [
    'type' => 'error',
    'pesan' => 'Username atau password salah.'
];

header('Location: login.php?redirect=' . urlencode($redirect));
exit;
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

csrf_verify();

$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];
if ($nama === '' || strlen($nama) > 100) {
    $errors[] = 'Nama wajib diisi dan maksimal 100 karakter.';
}
if ($username === '' || strlen($username) > 50 || !preg_match('/^[A-Za-z0-9_.-]+$/', $username)) {
    $errors[] = 'Username hanya boleh berisi huruf, angka, titik, garis bawah, atau tanda minus.';
}
if (strlen($password) < 6 || strlen($password) > 72) {
    $errors[] = 'Password harus 6-72 karakter.';
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: register.php');
    exit;
}

$cek = $pdo->prepare('SELECT id FROM users WHERE username = :username');
$cek->execute(['username' => $username]);
if ($cek->fetch()) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username sudah digunakan.'];
    header('Location: register.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO users (nama, username, password, role)
     VALUES (:nama, :username, :password, 'petugas')"
);
$stmt->execute([
    'nama' => $nama,
    'username' => $username,
    'password' => password_hash($password, PASSWORD_DEFAULT),
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Registrasi berhasil, silakan login.'];
header('Location: login.php');
exit;

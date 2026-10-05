<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}
csrf_verify();

$nama_matkul = trim($_POST['nama_matkul'] ?? '');
$dosen = trim($_POST['dosen'] ?? '');
$kelas = trim($_POST['kelas'] ?? '');

$errors = [];
if ($nama_matkul === '' || strlen($nama_matkul) > 100) $errors[] = 'Nama mata kuliah wajib diisi dan maksimal 100 karakter.';
if (strlen($dosen) > 100) $errors[] = 'Nama dosen maksimal 100 karakter.';
if (strlen($kelas) > 20) $errors[] = 'Kelas maksimal 20 karakter.';

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    'INSERT INTO mata_kuliah (nama_matkul, dosen, kelas)
     VALUES (:nama_matkul, :dosen, :kelas)'
);
$stmt->execute([
    'nama_matkul' => $nama_matkul,
    'dosen' => $dosen,
    'kelas' => $kelas
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Mata kuliah berhasil ditambahkan.'];
header('Location: index.php');
exit;

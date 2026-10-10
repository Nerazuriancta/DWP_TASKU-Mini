<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
csrf_verify();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nama_matkul = trim($_POST['nama_matkul'] ?? '');
$dosen = trim($_POST['dosen'] ?? '');
$kelas = trim($_POST['kelas'] ?? '');

$errors = [];
if ($id === false || $id <= 0) $errors[] = 'ID mata kuliah tidak valid.';
if ($nama_matkul === '' || strlen($nama_matkul) > 100) $errors[] = 'Nama mata kuliah wajib diisi dan maksimal 100 karakter.';
if (strlen($dosen) > 100) $errors[] = 'Nama dosen maksimal 100 karakter.';
if (strlen($kelas) > 20) $errors[] = 'Kelas maksimal 20 karakter.';

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode((string)$id));
    exit;
}

$stmt = $pdo->prepare(
    'UPDATE mata_kuliah SET nama_matkul = :nama_matkul, dosen = :dosen,
     kelas = :kelas WHERE id_matkul = :id'
);
$stmt->execute([
    'nama_matkul' => $nama_matkul,
    'dosen' => $dosen,
    'kelas' => $kelas,
    'id' => $id
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Mata kuliah berhasil diperbarui.'];
header('Location: index.php');
exit;

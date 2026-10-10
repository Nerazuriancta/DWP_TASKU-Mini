<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}
csrf_verify();

$id_matkul = filter_input(INPUT_POST, 'id_matkul', FILTER_VALIDATE_INT);
$nama_tugas = trim($_POST['nama_tugas'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$deadline = trim($_POST['deadline'] ?? '');
$prioritas = $_POST['prioritas'] ?? '';
$status = $_POST['status'] ?? '';
$catatan = trim($_POST['catatan'] ?? '');

$prioritas_valid = ['', 'Rendah', 'Sedang', 'Tinggi'];
$status_valid = ['Belum Dimulai', 'Sedang Dikerjakan', 'Selesai'];
$errors = [];

if ($id_matkul === false || $id_matkul <= 0) $errors[] = 'Mata kuliah tidak valid.';
if ($nama_tugas === '' || strlen($nama_tugas) > 150) $errors[] = 'Nama tugas wajib diisi dan maksimal 150 karakter.';
if (strlen($deskripsi) > 2000) $errors[] = 'Deskripsi maksimal 2000 karakter.';
$d = DateTime::createFromFormat('Y-m-d', $deadline);
if (!$d || $d->format('Y-m-d') !== $deadline) $errors[] = 'Format deadline tidak valid.';
if (!in_array($prioritas, $prioritas_valid, true)) $errors[] = 'Prioritas tidak valid.';
if (!in_array($status, $status_valid, true)) $errors[] = 'Status tidak valid.';
if (strlen($catatan) > 2000) $errors[] = 'Catatan maksimal 2000 karakter.';

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$cek = $pdo->prepare('SELECT id_matkul FROM mata_kuliah WHERE id_matkul = :id');
$cek->execute(['id' => $id_matkul]);
if (!$cek->fetch()) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Mata kuliah tidak ditemukan.'];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    'INSERT INTO tugas (id_matkul, nama_tugas, deskripsi, deadline, prioritas, status, catatan)
     VALUES (:id_matkul, :nama_tugas, :deskripsi, :deadline, :prioritas, :status, :catatan)'
);
$stmt->execute([
    'id_matkul' => $id_matkul,
    'nama_tugas' => $nama_tugas,
    'deskripsi' => $deskripsi,
    'deadline' => $deadline,
    'prioritas' => $prioritas,
    'status' => $status,
    'catatan' => $catatan
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Tugas berhasil ditambahkan.'];
header('Location: index.php');
exit;

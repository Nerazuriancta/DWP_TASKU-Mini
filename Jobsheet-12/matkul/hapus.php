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
if ($id !== false && $id > 0) {
    $stmt = $pdo->prepare('DELETE FROM mata_kuliah WHERE id_matkul = :id');
    $stmt->execute(['id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Mata kuliah berhasil dihapus.'];
}

header('Location: index.php');
exit;

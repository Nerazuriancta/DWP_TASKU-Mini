<?php
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';

$stmt = $pdo->prepare('SELECT * FROM mata_kuliah ORDER BY id_matkul DESC');
$stmt->execute();
$data_matkul = $stmt->fetchAll(PDO::FETCH_ASSOC);

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<main class="main-content">
    <?php if ($flash): ?>
        <p class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['pesan']) ?></p>
    <?php endif; ?>

    <div class="page-header">
        <h1>Mata Kuliah</h1>
        <p>Daftar mata kuliah yang tersimpan.</p>
    </div>

    <?php if ($sudahLogin): ?>
        <div class="form-actions"><a href="tambah.php" class="btn-primary">+ Tambah Mata Kuliah</a></div>
    <?php endif; ?>

    <div class="table-container">
        <table>
            <thead><tr><th>No</th><th>Nama Mata Kuliah</th><th>Dosen</th><th>Kelas</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php if (count($data_matkul) > 0): ?>
                <?php $no = 1; foreach ($data_matkul as $matkul): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($matkul['nama_matkul']) ?></td>
                        <td><?= e($matkul['dosen'] ?? '-') ?></td>
                        <td><?= e($matkul['kelas'] ?? '-') ?></td>
                        <td>
                            <?php if ($sudahLogin): ?>
                                <a href="edit.php?id=<?= (int)$matkul['id_matkul'] ?>" class="btn-edit">Edit</a>
                                <form method="post" action="hapus.php" class="inline-form"
                                      onsubmit="return confirm('Yakin ingin menghapus mata kuliah ini?')">
                                    <input type="hidden" name="id" value="<?= (int)$matkul['id_matkul'] ?>">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            <?php else: ?> - <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">Belum ada mata kuliah.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>

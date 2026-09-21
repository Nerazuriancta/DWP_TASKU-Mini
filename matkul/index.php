<?php
include __DIR__ . "/../config/koneksi.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/sidebar.php";

$sql = "SELECT * FROM mata_kuliah ORDER BY id_matkul DESC";
$stmt = $pdo->query($sql);
$data_matkul = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="main-content">

    <div class="page-header">
        <h1>Mata Kuliah</h1>
        <p>Daftar mata kuliah yang tersimpan.</p>
    </div>

    <div class="form-actions">
        <a href="tambah.php" class="btn-primary">
            + Tambah Mata Kuliah
        </a>
    </div>

    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (count($data_matkul) > 0): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($data_matkul as $matkul): ?>

                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?= htmlspecialchars($matkul["nama_matkul"]) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($matkul["dosen"] ?? "-") ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($matkul["kelas"] ?? "-") ?>
                            </td>

                            <td>
                                <a href="edit.php?id=<?= $matkul["id_matkul"] ?>" class="btn-edit">
                                    Edit
                                </a>

                                <a href="hapus.php?id=<?= $matkul["id_matkul"] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus mata kuliah ini?')">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="5">
                            Belum ada mata kuliah.
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</main>
<?php include __DIR__ . "/../includes/footer.php"; ?>
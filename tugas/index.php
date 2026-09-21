<?php
include "../config/koneksi.php";
include "../includes/header.php";
include "../includes/sidebar.php";

/* Mengambil semua data tugas */
$sql = "SELECT tugas.*, mata_kuliah.nama_matkul
        FROM tugas
        JOIN mata_kuliah
        ON tugas.id_matkul = mata_kuliah.id_matkul
        ORDER BY tugas.deadline ASC";

$stmt = $pdo->query($sql);
$data_tugas = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Mengambil data mata kuliah untuk filter */
$sql_matkul = "SELECT * FROM mata_kuliah ORDER BY nama_matkul ASC";
$stmt_matkul = $pdo->query($sql_matkul);
$data_matkul = $stmt_matkul->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="main-content">
    <div class="page-header">
        <h1>Semua Tugas</h1>
        <p>Daftar semua tugas yang kamu miliki.</p>
    </div>

    <div class="form-actions">
        <a href="tambah.php" class="btn-primary">
            + Tambah Tugas
        </a>
    </div>

    <!-- Search dan Filter -->
    <div class="filter-container">

        <div class="filter-group">
            <label for="search-input">Cari Tugas</label>
            <input type="text" id="search-input" placeholder="Cari nama tugas...">
        </div>

        <div class="filter-group">
            <label for="matkul-filter">Mata Kuliah</label>
            <select id="matkul-filter">
                <option value="">Semua Mata Kuliah</option>
                <?php foreach ($data_matkul as $matkul): ?>
                    <option value="<?= htmlspecialchars($matkul["nama_matkul"]) ?>">
                        <?= htmlspecialchars($matkul["nama_matkul"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label for="status-filter">Status</label>

            <select id="status-filter">
                <option value="">Semua Status</option>
                <option value="Belum Dimulai">Belum Dimulai</option>
                <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
    </div>

    <!-- Tabel Tugas -->
    <div class="table-container">
        <table id="tugas-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tugas</th>
                    <th>Mata Kuliah</th>
                    <th>Deadline</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (count($data_tugas) > 0): ?>

                    <?php $no = 1; ?>

                    <?php foreach ($data_tugas as $tugas): ?>

                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?= htmlspecialchars($tugas["nama_tugas"]) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($tugas["nama_matkul"]) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($tugas["deadline"]) ?>
                            </td>
                            <td>
                                <?php if ($tugas["prioritas"] == "Tinggi"): ?>
                                    <span class="badge badge-high">Tinggi</span>
                                <?php elseif ($tugas["prioritas"] == "Sedang"): ?>
                                    <span class="badge badge-medium">Sedang</span>
                                <?php elseif ($tugas["prioritas"] == "Rendah"): ?>
                                    <span class="badge badge-low">Rendah</span>
                                <?php else: ?> - <?php endif; ?>
                            </td>
                                
                            <td>
                                <?php if ($tugas["status"] == "Selesai"): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php elseif ($tugas["status"] == "Sedang Dikerjakan"): ?>
                                    <span class="badge badge-process">Sedang Dikerjakan</span>
                                <?php elseif ($tugas["status"] == "Belum Dimulai"): ?>
                                    <span class="badge badge-pending">Belum Dimulai</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="edit.php?id=<?= $tugas["id_tugas"] ?>" class="btn-edit">
                                    Edit
                                </a>
                                <a href="hapus.php?id=<?= $tugas["id_tugas"] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                    Hapus
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            Belum ada tugas.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include "../includes/footer.php"; ?>
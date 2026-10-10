<?php
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/csrf.php";
include __DIR__ . "/../includes/koneksi.php";


/* Mengambil data mata kuliah untuk pilihan form */
$sql_matkul = "SELECT * FROM mata_kuliah ORDER BY nama_matkul ASC";
$stmt_matkul = $pdo->prepare($sql_matkul);
$stmt_matkul->execute();
$data_matkul = $stmt_matkul->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/sidebar.php";
?>

<main class="main-content">
    <?php $flash = $_SESSION["flash"] ?? null; unset($_SESSION["flash"]); ?>
<?php if ($flash): ?><p class="flash flash-<?= htmlspecialchars($flash["type"]) ?>"><?= htmlspecialchars($flash["pesan"]) ?></p><?php endif; ?>

<div class="page-header">
        <h1>Tambah Tugas</h1>
        <p>Tambahkan tugas baru.</p>
    </div>

    <div class="form-container">
        <form method="POST" action="proses_tambah.php">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Nama Tugas *</label>
                <input type="text" name="nama_tugas" required>
            </div>

            <div class="form-group">
                <label>Mata Kuliah *</label>

                <select name="id_matkul" required>
                    <option value="">-- Pilih Mata Kuliah --</option>

                    <?php foreach ($data_matkul as $matkul): ?>
                        <option value="<?= $matkul["id_matkul"] ?>">
                            <?= htmlspecialchars($matkul["nama_matkul"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label>Deadline *</label>
                <input type="date" name="deadline" required>
            </div>

            <div class="form-group">
                <label>Prioritas</label>

                <select name="prioritas">
                    <option value="">-- Pilih Prioritas --</option>
                    <option value="Rendah">Rendah</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Tinggi">Tinggi</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status *</label>

                <select name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="Belum Dimulai">Belum Dimulai</option>
                    <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" rows="3"></textarea>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</main>
<?php include __DIR__ . "/../includes/footer.php"; ?>
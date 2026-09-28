<?php
require __DIR__ . "/../includes/auth.php";
include __DIR__ . "/../includes/koneksi.php";

$id = $_GET["id"];

/* Mengambil data tugas */
$sql = "SELECT * FROM tugas WHERE id_tugas = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

$tugas = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$tugas) {
    die("Data tugas tidak ditemukan.");
}

/* Jika form disubmit */
/* Mengambil data mata kuliah */
$sql_matkul = "SELECT * FROM mata_kuliah ORDER BY nama_matkul ASC";
$stmt_matkul = $pdo->query($sql_matkul);
$data_matkul = $stmt_matkul->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/sidebar.php";
?>

<main class="main-content">

    <?php $flash = $_SESSION["flash"] ?? null; unset($_SESSION["flash"]); ?>
<?php if ($flash): ?><p class="flash flash-<?= htmlspecialchars($flash["type"]) ?>"><?= htmlspecialchars($flash["pesan"]) ?></p><?php endif; ?>

<div class="page-header">
        <h1>Edit Tugas</h1>
        <p>Ubah data tugas.</p>
    </div>

    <div class="form-container">

        <form method="POST" action="proses_edit.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

            <div class="form-group">
                <label>Nama Tugas *</label>
                <input type="text" name="nama_tugas" value="<?= htmlspecialchars($tugas["nama_tugas"]) ?>" required>
            </div>

            <div class="form-group">
                <label>Mata Kuliah *</label>
                <select name="id_matkul" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                    <?php foreach ($data_matkul as $matkul): ?>

                        <option value="<?= $matkul["id_matkul"] ?>" <?= $tugas["id_matkul"] == $matkul["id_matkul"] ? "selected" : "" ?>>
                            <?= htmlspecialchars($matkul["nama_matkul"]) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>

                <textarea name="deskripsi" rows="4">
                    <?= htmlspecialchars($tugas["deskripsi"] ?? "") ?>
                </textarea>
            </div>

            <div class="form-group">
                <label>Deadline *</label>
                <input type="date" name="deadline" value="<?= htmlspecialchars($tugas["deadline"]) ?>" required>
            </div>

            <div class="form-group">
                <label>Prioritas</label>
                <select name="prioritas">
                    <option value="">-- Pilih Prioritas --</option>
                    <option value="Rendah" <?= $tugas["prioritas"] == "Rendah" ? "selected" : "" ?>>
                        Rendah
                    </option>

                    <option value="Sedang" <?= $tugas["prioritas"] == "Sedang" ? "selected" : "" ?>>
                        Sedang
                    </option>

                    <option value="Tinggi" <?= $tugas["prioritas"] == "Tinggi" ? "selected" : "" ?>>
                        Tinggi
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="Belum Dimulai" <?= $tugas["status"] == "Belum Dimulai" ? "selected" : "" ?>>
                        Belum Dimulai
                    </option>

                    <option value="Sedang Dikerjakan" <?= $tugas["status"] == "Sedang Dikerjakan" ? "selected" : "" ?>>
                        Sedang Dikerjakan
                    </option>

                    <option value="Selesai" <?= $tugas["status"] == "Selesai" ? "selected" : "" ?>>
                        Selesai
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Catatan</label>

                <textarea name="catatan" rows="3">
                    <?= htmlspecialchars($tugas["catatan"] ?? "") ?>
                </textarea>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</main>
<?php include __DIR__ . "/../includes/footer.php"; ?>
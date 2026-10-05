<?php
require __DIR__ . "/../includes/auth.php";
require __DIR__ . "/../includes/csrf.php";
include __DIR__ . "/../includes/koneksi.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if ($id === false || $id <= 0) { die("ID mata kuliah tidak valid."); }

$sql = "SELECT * FROM mata_kuliah WHERE id_matkul = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

$matkul = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$matkul) {
    die("Data mata kuliah tidak ditemukan.");
}

include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/sidebar.php";
?>

<main class="main-content">

    <?php $flash = $_SESSION["flash"] ?? null; unset($_SESSION["flash"]); ?>
<?php if ($flash): ?><p class="flash flash-<?= htmlspecialchars($flash["type"]) ?>"><?= htmlspecialchars($flash["pesan"]) ?></p><?php endif; ?>

<div class="page-header">
        <h1>Edit Mata Kuliah</h1>
        <p>Ubah data mata kuliah.</p>
    </div>

    <div class="form-container">
        <form method="POST" action="proses_edit.php">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
            <div class="form-group">
                <label>Nama Mata Kuliah *</label>
                <input type="text" name="nama_matkul" value="<?= htmlspecialchars($matkul["nama_matkul"]) ?>" required>
            </div>

            <div class="form-group">
                <label>Dosen</label>
                <input type="text" name="dosen" value="<?= htmlspecialchars($matkul["dosen"] ?? "") ?>">
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" value="<?= htmlspecialchars($matkul["kelas"] ?? "") ?>">
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
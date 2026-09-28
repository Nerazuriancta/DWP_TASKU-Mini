<?php
include __DIR__ . "/../includes/koneksi.php";

include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/sidebar.php";
?>

<main class="main-content">

    <?php $flash = $_SESSION["flash"] ?? null; unset($_SESSION["flash"]); ?>
<?php if ($flash): ?><p class="flash flash-<?= htmlspecialchars($flash["type"]) ?>"><?= htmlspecialchars($flash["pesan"]) ?></p><?php endif; ?>

<div class="page-header">
        <h1>Tambah Mata Kuliah</h1>
        <p>Tambahkan mata kuliah baru.</p>
    </div>

    <div class="form-container">

        <form method="POST" action="proses_tambah.php">
            <div class="form-group">
                <label>Nama Mata Kuliah *</label>
                <input type="text" name="nama_matkul" required>
            </div>

            <div class="form-group">
                <label>Dosen</label>
                <input type="text" name="dosen">
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas">
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    Simpan
                </button>
            </div>
        </form>

    </div>
</main>
<?php include __DIR__ . "/../includes/footer.php"; ?>
<?php
$page_title = 'Dashboard';
require __DIR__ . '/includes/koneksi.php';
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sidebar.php';

$stmt = $pdo->prepare('SELECT COUNT(*) FROM tugas');
$stmt->execute();
$total_tugas = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM tugas WHERE status = :status");
$stmt->execute(['status' => 'Belum Dimulai']);
$belum_dimulai = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM tugas WHERE status = :status");
$stmt->execute(['status' => 'Sedang Dikerjakan']);
$sedang_dikerjakan = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM tugas WHERE status = :status");
$stmt->execute(['status' => 'Selesai']);
$selesai = $stmt->fetchColumn();

$stmt = $pdo->prepare(
    'SELECT tugas.*, mata_kuliah.nama_matkul
     FROM tugas
     JOIN mata_kuliah ON tugas.id_matkul = mata_kuliah.id_matkul
     WHERE tugas.deadline >= CURRENT_DATE
       AND tugas.status <> :status_selesai
     ORDER BY tugas.deadline ASC
     LIMIT 1'
);
$stmt->execute(['status_selesai' => 'Selesai']);
$deadline_terdekat = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<main class="main-content">
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Selamat datang di TASKU-Mini 👋 Kelola tugas dan mata kuliah dalam satu tempat.</p>
        <?php if ($sudahLogin): ?>
            <div class="form-actions">
                <a href="tugas/tambah.php" class="btn-primary">+ Tambah Tugas</a>
                <a href="matkul/tambah.php" class="btn-secondary">+ Tambah Mata Kuliah</a>
            </div>
        <?php else: ?>
            <p><a href="auth/login.php">Login</a> untuk menambah, mengubah, atau menghapus data.</p>
        <?php endif; ?>
    </div>

    <div class="dashboard-cards">
        <div class="card"><h3>Total Tugas</h3><p><?= e($total_tugas) ?></p></div>
        <div class="card"><h3>Belum Dimulai</h3><p><?= e($belum_dimulai) ?></p></div>
        <div class="card"><h3>Sedang Dikerjakan</h3><p><?= e($sedang_dikerjakan) ?></p></div>
        <div class="card"><h3>Selesai</h3><p><?= e($selesai) ?></p></div>
    </div>

    <div class="deadline-section">
        <h2>Deadline Terdekat</h2>
        <?php if ($deadline_terdekat): ?>
            <div class="empty-state">
                <h3><?= e($deadline_terdekat['nama_tugas']) ?></h3>
                <p><?= e($deadline_terdekat['nama_matkul']) ?></p>
                <p>Deadline: <?= e($deadline_terdekat['deadline']) ?></p>
                <p>Status: <?= e($deadline_terdekat['status']) ?></p>
                <?php if ($sudahLogin): ?>
                    <p><a class="btn-primary" href="tugas/edit.php?id=<?= (int) $deadline_terdekat['id_tugas'] ?>">Kelola Tugas</a></p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="empty-state"><p>Tidak ada deadline terdekat.</p></div>
        <?php endif; ?>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>

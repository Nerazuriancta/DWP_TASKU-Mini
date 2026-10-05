<?php
require __DIR__ . '/includes/auth.php';
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
     ORDER BY tugas.deadline ASC
     LIMIT 1'
);
$stmt->execute();
$deadline_terdekat = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<main class="main-content">
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Selamat datang di TASKU-Mini 👋</p>
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
            </div>
        <?php else: ?>
            <div class="empty-state"><p>Tidak ada deadline terdekat.</p></div>
        <?php endif; ?>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>

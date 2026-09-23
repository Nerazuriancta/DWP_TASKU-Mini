<?php
include __DIR__ . "/config/koneksi.php";
include __DIR__ . "/includes/header.php";
include __DIR__ . "/includes/sidebar.php";

/* Menghitung total tugas */
$sql = "SELECT COUNT(*) FROM tugas";
$total_tugas = $pdo->query($sql)->fetchColumn();

/* Menghitung tugas yang belum dimulai */
$sql = "SELECT COUNT(*) FROM tugas WHERE status = 'Belum Dimulai'";
$belum_dimulai = $pdo->query($sql)->fetchColumn();

/* Menghitung tugas yang sedang dikerjakan */
$sql = "SELECT COUNT(*) FROM tugas WHERE status = 'Sedang Dikerjakan'";
$sedang_dikerjakan = $pdo->query($sql)->fetchColumn();

/* Menghitung tugas yang sudah selesai */
$sql = "SELECT COUNT(*) FROM tugas WHERE status = 'Selesai'";
$selesai = $pdo->query($sql)->fetchColumn();

/* Mengambil deadline terdekat */
$sql = "SELECT tugas.*, mata_kuliah.nama_matkul
        FROM tugas
        JOIN mata_kuliah
        ON tugas.id_matkul = mata_kuliah.id_matkul
        WHERE tugas.deadline >= CURRENT_DATE
        ORDER BY tugas.deadline ASC
        LIMIT 1";

$stmt = $pdo->query($sql);
$deadline_terdekat = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<main class="main-content">
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Selamat datang di TASKU-Mini 👋</p>
    </div>

    <div class="dashboard-cards">
        <div class="card">
            <h3>Total Tugas</h3>
            <p><?= $total_tugas ?></p>
        </div>

        <div class="card">
            <h3>Belum Dimulai</h3>
            <p><?= $belum_dimulai ?></p>
        </div>

        <div class="card">
            <h3>Sedang Dikerjakan</h3>
            <p><?= $sedang_dikerjakan ?></p>
        </div>

        <div class="card">
            <h3>Selesai</h3>
            <p><?= $selesai ?></p>
        </div>

    </div>

    <div class="deadline-section">
        <h2>Deadline Terdekat</h2>
        <?php if ($deadline_terdekat): ?>

            <div class="empty-state">
                <h3><?= htmlspecialchars($deadline_terdekat["nama_tugas"]) ?></h3>

                <p><?= htmlspecialchars($deadline_terdekat["nama_matkul"]) ?></p>
                <p>Deadline:<?= htmlspecialchars($deadline_terdekat["deadline"]) ?></p>
            </div>
        <?php else: ?>

            <div class="empty-state">
                <p>Tidak ada deadline terdekat.</p>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php include __DIR__ . "/includes/footer.php"; ?>


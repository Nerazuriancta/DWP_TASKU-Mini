<?php
include __DIR__ . "/../config/koneksi.php";
include __DIR__ . "/../includes/header.php";
include __DIR__ . "/../includes/sidebar.php";
include __DIR__ . "/../includes/footer.php";

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
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_matkul = $_POST["id_matkul"];
    $nama_tugas = $_POST["nama_tugas"];
    $deskripsi = $_POST["deskripsi"];
    $deadline = $_POST["deadline"];
    $prioritas = $_POST["prioritas"];
    $status = $_POST["status"];
    $catatan = $_POST["catatan"];

    $sql = "UPDATE tugas
            SET id_matkul = :id_matkul,
                nama_tugas = :nama_tugas,
                deskripsi = :deskripsi,
                deadline = :deadline,
                prioritas = :prioritas,
                status = :status,
                catatan = :catatan
            WHERE id_tugas = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":id_matkul" => $id_matkul,
        ":nama_tugas" => $nama_tugas,
        ":deskripsi" => $deskripsi,
        ":deadline" => $deadline,
        ":prioritas" => $prioritas,
        ":status" => $status,
        ":catatan" => $catatan,
        ":id" => $id
    ]);

    header("Location: index.php");
    exit;
}

/* Mengambil data mata kuliah */
$sql_matkul = "SELECT * FROM mata_kuliah ORDER BY nama_matkul ASC";
$stmt_matkul = $pdo->query($sql_matkul);
$data_matkul = $stmt_matkul->fetchAll(PDO::FETCH_ASSOC);

include "../includes/header.php";
include "../includes/sidebar.php";
?>

<main class="main-content">

    <div class="page-header">
        <h1>Edit Tugas</h1>
        <p>Ubah data tugas.</p>
    </div>

    <div class="form-container">

        <form method="POST">

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
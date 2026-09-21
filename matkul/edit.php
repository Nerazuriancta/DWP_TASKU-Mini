<?php
include __DIR__ . "/../config/koneksi.php";

$id = $_GET["id"];

$sql = "SELECT * FROM mata_kuliah WHERE id_matkul = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $id]);

$matkul = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$matkul) {
    die("Data mata kuliah tidak ditemukan.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama_matkul = $_POST["nama_matkul"];
    $dosen = $_POST["dosen"];
    $kelas = $_POST["kelas"];

    $sql = "UPDATE mata_kuliah
            SET nama_matkul = :nama_matkul,
                dosen = :dosen,
                kelas = :kelas
            WHERE id_matkul = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":nama_matkul" => $nama_matkul,
        ":dosen" => $dosen,
        ":kelas" => $kelas,
        ":id" => $id
    ]);

    header("Location: index.php");
    exit;
}

include "../includes/header.php";
include "../includes/sidebar.php";
?>

<main class="main-content">

    <div class="page-header">
        <h1>Edit Mata Kuliah</h1>
        <p>Ubah data mata kuliah.</p>
    </div>

    <div class="form-container">
        <form method="POST">
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
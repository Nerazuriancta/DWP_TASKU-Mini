<?php
include "../config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama_matkul = $_POST["nama_matkul"];
    $dosen = $_POST["dosen"];
    $kelas = $_POST["kelas"];

    $sql = "INSERT INTO mata_kuliah (nama_matkul, dosen, kelas)
            VALUES (:nama_matkul, :dosen, :kelas)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ":nama_matkul" => $nama_matkul,
        ":dosen" => $dosen,
        ":kelas" => $kelas
    ]);

    header("Location: index.php");
    exit;
}

include "../includes/header.php";
include "../includes/sidebar.php";
?>

<main class="main-content">

    <div class="page-header">
        <h1>Tambah Mata Kuliah</h1>
        <p>Tambahkan mata kuliah baru.</p>
    </div>

    <div class="form-container">

        <form method="POST">
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
<?php include "../includes/footer.php"; ?>
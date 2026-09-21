<?php
include __DIR__ . "/../config/koneksi.php";

$id = $_GET["id"];

$sql = "DELETE FROM mata_kuliah WHERE id_matkul = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

header("Location: index.php");
exit;
?>
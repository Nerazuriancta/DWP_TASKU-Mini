<?php
include "../config/koneksi.php";

$id = $_GET["id"];
$sql = "DELETE FROM tugas WHERE id_tugas = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([ ":id" => $id ]);

header("Location: index.php");
exit;
?>
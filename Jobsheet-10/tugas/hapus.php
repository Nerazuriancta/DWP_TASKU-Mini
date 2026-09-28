<?php
require __DIR__ . "/../includes/auth.php";
session_start(); require __DIR__ . '/../includes/koneksi.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: index.php');exit;}
$id=(int)($_POST['id']??0);if($id>0){$stmt=$pdo->prepare('DELETE FROM tugas WHERE id_tugas=:id');$stmt->execute(['id'=>$id]);$_SESSION['flash']=['type'=>'success','pesan'=>'Tugas berhasil dihapus.'];}header('Location: index.php');exit;

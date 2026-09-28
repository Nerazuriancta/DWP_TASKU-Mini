<?php
require __DIR__ . "/../includes/auth.php";
session_start(); require __DIR__ . '/../includes/koneksi.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: index.php');exit;}
$id=(int)($_POST['id']??0);if($id>0){$stmt=$pdo->prepare('DELETE FROM mata_kuliah WHERE id_matkul=:id');$stmt->execute(['id'=>$id]);$_SESSION['flash']=['type'=>'success','pesan'=>'Mata kuliah berhasil dihapus.'];}header('Location: index.php');exit;

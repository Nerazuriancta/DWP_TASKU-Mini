<?php
session_start(); require __DIR__ . '/../includes/koneksi.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: index.php');exit;}
$data=['id'=>(int)($_POST['id']??0),'nama_matkul'=>trim($_POST['nama_matkul']??''),'dosen'=>trim($_POST['dosen']??''),'kelas'=>trim($_POST['kelas']??'')];if($data['id']<=0||$data['nama_matkul']===''){$_SESSION['flash']=['type'=>'error','pesan'=>'Data mata kuliah belum lengkap.'];header('Location: edit.php?id='.$data['id']);exit;}$stmt=$pdo->prepare('UPDATE mata_kuliah SET nama_matkul=:nama_matkul,dosen=:dosen,kelas=:kelas WHERE id_matkul=:id');$stmt->execute($data);$_SESSION['flash']=['type'=>'success','pesan'=>'Mata kuliah berhasil diperbarui.'];header('Location: index.php');exit;

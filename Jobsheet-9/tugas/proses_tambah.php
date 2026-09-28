<?php
session_start(); require __DIR__ . '/../includes/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: tambah.php'); exit; }
$data=['id_matkul'=>(int)($_POST['id_matkul']??0),'nama_tugas'=>trim($_POST['nama_tugas']??''),'deskripsi'=>trim($_POST['deskripsi']??''),'deadline'=>$_POST['deadline']??'','prioritas'=>$_POST['prioritas']??'','status'=>$_POST['status']??'','catatan'=>trim($_POST['catatan']??'')];
if($data['id_matkul']<=0||$data['nama_tugas']===''||$data['deadline']===''||$data['status']===''){$_SESSION['flash']=['type'=>'error','pesan'=>'Nama tugas, mata kuliah, deadline, dan status wajib diisi.'];header('Location: tambah.php');exit;}
$stmt=$pdo->prepare('INSERT INTO tugas (id_matkul,nama_tugas,deskripsi,deadline,prioritas,status,catatan) VALUES (:id_matkul,:nama_tugas,:deskripsi,:deadline,:prioritas,:status,:catatan)');$stmt->execute($data);$_SESSION['flash']=['type'=>'success','pesan'=>'Tugas berhasil ditambahkan.'];header('Location: index.php');exit;

<?php
require __DIR__ . "/../includes/auth.php";
require_once __DIR__ . '/../includes/csrf.php'; require __DIR__ . '/../includes/koneksi.php';
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: tambah.php');exit;}
csrf_verify();
$data=['nama_matkul'=>trim($_POST['nama_matkul']??''),'dosen'=>trim($_POST['dosen']??''),'kelas'=>trim($_POST['kelas']??'')];if($data['nama_matkul']===''){$_SESSION['flash']=['type'=>'error','pesan'=>'Nama mata kuliah wajib diisi.'];header('Location: tambah.php');exit;}$stmt=$pdo->prepare('INSERT INTO mata_kuliah (nama_matkul,dosen,kelas) VALUES (:nama_matkul,:dosen,:kelas)');$stmt->execute($data);$_SESSION['flash']=['type'=>'success','pesan'=>'Mata kuliah berhasil ditambahkan.'];header('Location: index.php');exit;

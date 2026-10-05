<?php
require __DIR__ . "/../includes/auth.php";
require_once __DIR__ . '/../includes/csrf.php'; 
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
csrf_verify();
$data=['id'=>(int)($_POST['id']??0),'id_matkul'=>(int)($_POST['id_matkul']??0),'nama_tugas'=>trim($_POST['nama_tugas']??''),'deskripsi'=>trim($_POST['deskripsi']??''),'deadline'=>$_POST['deadline']??'','prioritas'=>$_POST['prioritas']??'','status'=>$_POST['status']??'','catatan'=>trim($_POST['catatan']??'')];
if($data['id']<=0||$data['id_matkul']<=0||$data['nama_tugas']===''||$data['deadline']===''||$data['status']===''){$_SESSION['flash']=['type'=>'error','pesan'=>'Data tugas belum lengkap.'];header('Location: edit.php?id='.$data['id']);exit;}
$stmt=$pdo->prepare('UPDATE tugas SET id_matkul=:id_matkul,nama_tugas=:nama_tugas,deskripsi=:deskripsi,deadline=:deadline,prioritas=:prioritas,status=:status,catatan=:catatan WHERE id_tugas=:id');$stmt->execute($data);$_SESSION['flash']=['type'=>'success','pesan'=>'Tugas berhasil diperbarui.'];header('Location: index.php');exit;

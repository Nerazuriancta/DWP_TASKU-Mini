<?php
$host = "aws-0-ap-northeast-1.pooler.supabase.com";
$port = "5432";
$dbname = "postgres";
$user = "postgres.zbrpkebarphculvwxgmf";
$password = "Nerazuriancta";

try {
    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
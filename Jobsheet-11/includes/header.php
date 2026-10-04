<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';

$__root = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__root))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
$sudahLogin = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASKU-Mini<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/style.css">
</head>
<body>
<header class="top-header">
    <div><h1>TASKU-Mini</h1><p>Task Management</p></div>
    <div class="auth-status">
        <?php if ($sudahLogin): ?>
            <span>Halo, <?php echo e($_SESSION['nama']); ?></span>
            <a href="<?php echo $base; ?>auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="<?php echo $base; ?>auth/login.php">Login</a>
        <?php endif; ?>
    </div>
</header>
<main>

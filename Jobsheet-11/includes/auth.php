<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    $redirect = $_SERVER['REQUEST_URI'] ?? '/Jobsheet-11/index.php';

    header('Location: ../auth/login.php?redirect=' . urlencode($redirect));
    exit;
}
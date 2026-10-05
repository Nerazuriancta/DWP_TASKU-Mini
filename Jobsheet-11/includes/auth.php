<?php
require_once __DIR__ . '/session.php';

if (!isset($_SESSION['user_id'])) {
    $redirect = $_SERVER['REQUEST_URI'] ?? '/Jobsheet-11/index.php';

    header(
        'Location: /Jobsheet-11/auth/login.php?redirect=' .
        urlencode($redirect)
    );
    exit;
}
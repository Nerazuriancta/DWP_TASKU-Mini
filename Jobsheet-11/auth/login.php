<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/helpers.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | TASKU-Mini</title>

    <link rel="stylesheet" href="../assets/style.css">

    <style>
        .auth-page {
            min-height: 100vh;
            margin: 0;
            background: #f5f7ff;
            display: flex;
            flex-direction: column;
        }

        .auth-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 20px 7%;
        }

        .auth-header h1 {
            margin: 0;
            color: #172554;
            font-size: 28px;
        }

        .auth-header p {
            margin: 4px 0 0;
            color: #64748b;
        }

        .auth-main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            background: #ffffff;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            box-sizing: border-box;
        }

        .auth-card h2 {
            margin: 0 0 8px;
            color: #172554;
            font-size: 30px;
        }

        .auth-description {
            margin: 0 0 25px;
            color: #64748b;
        }

        .auth-form .form-group {
            margin-bottom: 18px;
        }

        .auth-form label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #1e293b;
        }

        .auth-form input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            font-size: 15px;
            box-sizing: border-box;
        }

        .auth-form input:focus {
            outline: none;
            border-color: #4f6df5;
        }

        .auth-form .form-actions {
            margin-top: 24px;
        }

        .auth-form .btn-primary {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 9px;
            background: #4f6df5;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .auth-form .btn-primary:hover {
            background: #3f5de0;
        }

        .auth-link {
            margin-top: 22px;
            text-align: center;
            color: #64748b;
        }

        .auth-link a {
            color: #405de6;
            font-weight: 600;
            text-decoration: none;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }

        .auth-flash {
            padding: 11px 14px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        .auth-flash-success {
            background: #dcfce7;
            color: #166534;
        }

        .auth-flash-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .auth-footer {
            text-align: center;
            padding: 18px;
            color: #64748b;
            font-size: 14px;
        }
    </style>
</head>

<body class="auth-page">

<header class="auth-header">
    <h1>TASKU-Mini</h1>
    <p>Task Management</p>
</header>

<main class="auth-main">
    <section class="auth-card">

        <h2>Login TASKU-Mini</h2>

        <p class="auth-description">
            Masuk untuk mengelola tugas dan mata kuliah.
        </p>

        <?php if ($flash): ?>
            <div class="auth-flash auth-flash-<?= e($flash['type']) ?>">
                <?= e($flash['pesan']) ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" method="post" action="proses_login.php">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    Masuk
                </button>
            </div>

        </form>

        <p class="auth-link">
            Belum punya akun?
            <a href="register.php">Daftar di sini</a>
        </p>

    </section>
</main>

<footer class="auth-footer">
    &copy; 2026 TASKU-Mini — Jobsheet 11
</footer>

</body>
</html>
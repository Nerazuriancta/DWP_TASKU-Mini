<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/csrf.php';

/*
 * Menentukan halaman tujuan setelah login.
 * Jika tidak ada redirect, kembali ke dashboard.
 */
$redirect = $_GET['redirect'] ?? '../index.php';

/*
 * Validasi redirect agar hanya menuju halaman dalam aplikasi,
 * bukan ke website lain.
 */
$redirectPath = parse_url($redirect, PHP_URL_PATH);

if (
    !$redirectPath ||
    str_starts_with($redirect, '//') ||
    preg_match('/^[a-z][a-z0-9+.-]*:/i', $redirect) ||
    strpos($redirectPath, '..') !== false
) {
    $redirect = '../index.php';
}

/*
 * Kalau user sudah login, langsung menuju halaman tujuan.
 */
if (isset($_SESSION['user_id'])) {
    header('Location: ' . $redirect);
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
    <title>Login - TASKU-Mini</title>

    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

    <div class="auth-container">

        <div class="auth-card">

            <div class="auth-header">
                <h1>Login</h1>
                <p>Masuk ke TASKU-Mini</p>
            </div>

            <?php if ($flash): ?>
                <p class="flash flash-<?= e($flash['type']) ?>">
                    <?= e($flash['pesan']) ?>
                </p>
            <?php endif; ?>

            <form class="auth-form" method="post" action="proses_login.php">

                <?= csrf_field() ?>

                <!-- Menyimpan halaman yang ingin dituju setelah login -->
                <input
                    type="hidden"
                    name="redirect"
                    value="<?= e($redirect) ?>"
                >

                <div class="form-group">
                    <label for="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        required
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="btn-primary">
                    Login
                </button>

            </form>

            <div class="auth-footer">
                <p>
                    Belum punya akun?
                    <a href="register.php">Daftar sekarang</a>
                </p>
            </div>

        </div>

    </div>

</body>

</html>
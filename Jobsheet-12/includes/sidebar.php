<?php
$current_page = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
?>

<!-- Overlay untuk menu hamburger di HP -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h2>TASKU-Mini</h2>
        <p>Task Management</p>
    </div>

    <nav class="sidebar-menu">
        <a href="<?php echo $base; ?>index.php">🏠 Dashboard</a>
        <a href="<?php echo $base; ?>tugas/index.php">📝 Semua Tugas</a>

        <?php if ($sudahLogin): ?>
            <a href="<?php echo $base; ?>tugas/tambah.php">➕ Tambah Tugas</a>
        <?php endif; ?>

        <a href="<?php echo $base; ?>matkul/index.php">📚 Mata Kuliah</a>

        <?php if ($sudahLogin): ?>
            <a href="<?php echo $base; ?>matkul/tambah.php">➕ Tambah Mata Kuliah</a>
        <?php endif; ?>

        <a href="<?php echo $base; ?>tentang/index.php">ℹ️ Tentang</a>
    </nav>

    <div class="sidebar-auth">
        <?php if ($sudahLogin): ?>
            <a href="<?php echo $base; ?>auth/logout.php">🚪 Logout</a>
        <?php else: ?>
            <a href="<?php echo $base; ?>auth/login.php">🔐 Login</a>
        <?php endif; ?>
    </div>
</aside>
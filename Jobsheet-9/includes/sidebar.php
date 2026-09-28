<?php
$current_page = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
?>

<aside class="sidebar">

    <div class="sidebar-header">
        <h2>TASKU-Mini</h2>
        <p>Task Management</p>
    </div>

    <nav class="sidebar-menu">

        <a href="<?php echo $base; ?>index.php">
            🏠 Dashboard
        </a>

        <a href="<?php echo $base; ?>tugas/index.php">
            📝 Semua Tugas
        </a>

        <a href="<?php echo $base; ?>tugas/tambah.php">
            ➕ Tambah Tugas
        </a>

        <a href="<?php echo $base; ?>matkul/index.php">
            📚 Mata Kuliah
        </a>

        <a href="<?php echo $base; ?>matkul/tambah.php">
            ➕ Tambah Mata Kuliah
        </a>

        <a href="<?php echo $base; ?>tentang/index.php">
            ℹ️ Tentang
        </a>

    </nav>

</aside>
<?php

$current_page = $_SERVER["REQUEST_URI"];

?>

<aside class="sidebar">

    <div class="sidebar-header">
        <h2>TASKU-Mini</h2>
        <p>Task Management</p>
    </div>

    <nav class="sidebar-menu">
        <a href="/index.php" class="<?= $current_page == "/index.php" ? "active" : "" ?>">
            🏠 Dashboard
        </a>

        <a href="/tugas/index.php" class="<?= $current_page == "/tugas/index.php" ? "active" : "" ?>">
            📝 Semua Tugas
        </a>

        <a href="/tugas/tambah.php" class="<?= $current_page == "/tugas/tambah.php" ? "active" : "" ?>">
            ➕ Tambah Tugas
        </a>

        <a href="/matkul/index.php" class="<?= $current_page == "/matkul/index.php" ? "active" : "" ?>">
            📚 Mata Kuliah
        </a>

        <a href="/tentang/index.php" class="<?= $current_page == "/tentang/index.php" ? "active" : "" ?>">
            ℹ️ Tentang
        </a>

    </nav>

</aside>
<?php

$current_page = parse_url(
    $_SERVER["REQUEST_URI"] ?? "",
    PHP_URL_PATH
);

?>
<aside class="sidebar">

    <div class="sidebar-header">

        <h2>
            TASKU-Mini
        </h2>

        <p>
            Task Management
        </p>

    </div>

    <nav class="sidebar-menu">

        <a
            href="/Jobsheet-8/index.php"
            class="<?= $current_page == "/Jobsheet-8/index.php" ? "active" : "" ?>"
        >
            🏠 Dashboard
        </a>


        <a
            href="/Jobsheet-8/tugas/index.php"
            class="<?= $current_page == "/Jobsheet-8/tugas/index.php" ? "active" : "" ?>"
        >
            📝 Semua Tugas
        </a>


        <a
            href="/Jobsheet-8/tugas/tambah.php"
            class="<?= $current_page == "/Jobsheet-8/tugas/tambah.php" ? "active" : "" ?>">
            ➕ Tambah Tugas
        </a>


        <a
            href="/Jobsheet-8/matkul/index.php"
            class="<?= $current_page == "/Jobsheet-8/matkul/index.php" ? "active" : "" ?>"
        >
            📚 Mata Kuliah
        </a>


        <a
            href="/Jobsheet-8/tentang/index.php"
            class="<?= $current_page == "/Jobsheet-8/tentang/index.php" ? "active" : "" ?>"
        >
            ℹ️ Tentang
        </a>

    </nav>

</aside>
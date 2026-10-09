// Search dan filter tugas
const searchInput = document.getElementById("search-input");
const matkulFilter = document.getElementById("matkul-filter");
const statusFilter = document.getElementById("status-filter");
const tugasTable = document.getElementById("tugas-table");

function filterTugas() {
    // Pastikan elemen filter tersedia di halaman
    if (!searchInput || !matkulFilter || !statusFilter || !tugasTable) {
        return;
    }

    const searchValue = searchInput.value.toLowerCase();
    const matkulValue = matkulFilter.value.toLowerCase();
    const statusValue = statusFilter.value.toLowerCase();

    const rows = tugasTable.querySelectorAll("tbody tr");

    rows.forEach(function (row) {
        const namaTugas = row.cells[1]?.textContent.trim().toLowerCase() || "";
        const namaMatkul = row.cells[2]?.textContent.trim().toLowerCase() || "";
        const status = row.cells[5]?.textContent.trim().toLowerCase() || "";

        const cocokSearch = namaTugas.includes(searchValue);
        const cocokMatkul =
            matkulValue === "" || namaMatkul.includes(matkulValue);
        const cocokStatus =
            statusValue === "" || status === statusValue;

        row.style.display =
            cocokSearch && cocokMatkul && cocokStatus ? "" : "none";
    });
}

if (searchInput && matkulFilter && statusFilter && tugasTable) {
    searchInput.addEventListener("input", filterTugas);
    matkulFilter.addEventListener("change", filterTugas);
    statusFilter.addEventListener("change", filterTugas);
}

// Hamburger menu untuk HP
document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menuToggle");
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebarOverlay");

    if (!menuToggle || !sidebar || !overlay) {
        return;
    }

    function toggleMenu(open) {
        sidebar.classList.toggle("active", open);
        overlay.classList.toggle("active", open);

        menuToggle.setAttribute("aria-expanded", String(open));
        menuToggle.setAttribute(
            "aria-label",
            open ? "Tutup menu" : "Buka menu"
        );
        menuToggle.textContent = open ? "✕" : "☰";
    }

    menuToggle.addEventListener("click", function () {
        toggleMenu(!sidebar.classList.contains("active"));
    });

    overlay.addEventListener("click", function () {
        toggleMenu(false);
    });

    sidebar.querySelectorAll("a").forEach(function (link) {
        link.addEventListener("click", function () {
            toggleMenu(false);
        });
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            toggleMenu(false);
        }
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 700) {
            toggleMenu(false);
        }
    });
});
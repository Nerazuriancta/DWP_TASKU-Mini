// Search dan filter tugas
const searchInput = document.getElementById("search-input");
const matkulFilter = document.getElementById("matkul-filter");
const statusFilter = document.getElementById("status-filter");
const tugasTable = document.getElementById("tugas-table");

function filterTugas() {

    const searchValue = searchInput.value.toLowerCase();
    const matkulValue = matkulFilter.value.toLowerCase();
    const statusValue = statusFilter.value.toLowerCase();

    const rows = tugasTable.querySelectorAll("tbody tr");

    rows.forEach(function(row) {

        const namaTugas = row.cells[1].textContent.trim().toLowerCase();
        const namaMatkul = row.cells[2].textContent.trim().toLowerCase();
        const status = row.cells[5].textContent.trim().toLowerCase();

        const cocokSearch = namaTugas.includes(searchValue);
        const cocokMatkul =
            matkulValue === "" || namaMatkul.includes(matkulValue);

        const cocokStatus =
            statusValue === "" || status === statusValue;

        if (cocokSearch && cocokMatkul && cocokStatus) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });
}

if (searchInput) {
    searchInput.addEventListener("input", filterTugas);
}

if (matkulFilter) {
    matkulFilter.addEventListener("change", filterTugas);
}

if (statusFilter) {
    statusFilter.addEventListener("change", filterTugas);
}
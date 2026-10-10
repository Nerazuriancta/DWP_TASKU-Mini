document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initTableFilter();
    initFormValidation();
    tampilkanDataTersimpan();
    initHapusConfirm();
});

// ===============================
// NAVIGASI
// ===============================
function initNavToggle() {
    const toggle = document.querySelector(".nav-toggle");
    const nav = document.querySelector(".nav-menu");

    if (toggle && nav) {
        toggle.addEventListener("click", function () {
            nav.classList.toggle("active");
        });
    }
}

// ===============================
// VALIDASI FORM DAN SIMPAN DATA
// ===============================
function initFormValidation() {
    const form = document.querySelector("#form-tambah");

    if (!form) return;

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const inputJudul = form.querySelector("[name='judul']");
        const inputNoAnggota = form.querySelector("[name='no_anggota']");

        // FORM TAMBAH BUKU
        if (inputJudul) {
            const buku = {
                id: Date.now(),
                judul: inputJudul.value.trim(),
                pengarang: form.querySelector("[name='pengarang']")?.value.trim() || "",
                tahun: form.querySelector("[name='tahun']")?.value.trim() || "",
                isbn: form.querySelector("[name='isbn']")?.value.trim() || "",
                stok: form.querySelector("[name='stok']")?.value.trim() || "",
                kategori: form.querySelector("[name='kategori']")?.value.trim() || ""
            };

            const daftarBuku = JSON.parse(
                localStorage.getItem("daftarBuku") || "[]"
            );

            daftarBuku.push(buku);
            localStorage.setItem("daftarBuku", JSON.stringify(daftarBuku));

            alert("Data buku berhasil ditambahkan!");
            window.location.href = "list.html";
            return;
        }

        // FORM TAMBAH ANGGOTA
        if (inputNoAnggota) {
            const anggota = {
                id: Date.now(),
                no_anggota: inputNoAnggota.value.trim(),
                nama: form.querySelector("[name='nama']")?.value.trim() || "",
                alamat: form.querySelector("[name='alamat']")?.value.trim() || "",
                no_hp: form.querySelector("[name='no_hp']")?.value.trim() || ""
            };

            const daftarAnggota = JSON.parse(
                localStorage.getItem("daftarAnggota") || "[]"
            );

            daftarAnggota.push(anggota);
            localStorage.setItem(
                "daftarAnggota",
                JSON.stringify(daftarAnggota)
            );

            alert("Data anggota berhasil ditambahkan!");
            window.location.href = "list.html";
            return;
        }

        alert("Form berhasil divalidasi.");
    });
}

// ===============================
// MENAMPILKAN DATA DARI LOCALSTORAGE
// ===============================
function tampilkanDataTersimpan() {
    const tabel = document.querySelector(".table-responsive table");

    if (!tabel) return;

    const tbody = tabel.querySelector("tbody");

    if (!tbody) return;

    const halamanBuku = window.location.pathname.includes("/buku/");
    const halamanAnggota = window.location.pathname.includes("/anggota/");

    if (!halamanBuku && !halamanAnggota) return;

    const key = halamanBuku ? "daftarBuku" : "daftarAnggota";
    const keyHapus = "dataDihapus_" + key;

    const dataDihapus = JSON.parse(
        localStorage.getItem(keyHapus) || "[]"
    );

    // Menyembunyikan data bawaan yang sudah dihapus.
    tbody.querySelectorAll("tr:not([data-local-id])").forEach(function (row) {
        const nilaiBaris = Array.from(row.querySelectorAll("td"))
            .slice(0, -1)
            .map(function (td) {
                return td.textContent.trim();
            });

        if (dataDihapus.includes(JSON.stringify(nilaiBaris))) {
            row.remove();
        }
    });

    // Menghapus tampilan data tambahan agar tidak muncul dua kali.
    tbody.querySelectorAll("tr[data-local-id]").forEach(function (row) {
        row.remove();
    });

    const data = JSON.parse(localStorage.getItem(key) || "[]");

    data.forEach(function (item, index) {
        const row = document.createElement("tr");
        row.dataset.localId = item.id;

        if (halamanBuku) {
            row.innerHTML = `
                <td>${escapeHTML(item.judul)}</td>
                <td>${escapeHTML(item.pengarang)}</td>
                <td>${escapeHTML(item.tahun)}</td>
                <td>${escapeHTML(item.stok)}</td>
                <td>
                    <button type="button" class="btn-edit">Edit</button>
                    <button type="button" class="btn-hapus">Hapus</button>
                </td>
            `;
        } else {
            row.innerHTML = `
                <td>${escapeHTML(item.no_anggota)}</td>
                <td>${escapeHTML(item.nama)}</td>
                <td>${escapeHTML(item.alamat)}</td>
                <td>${escapeHTML(item.no_hp)}</td>
                <td>
                    <button type="button" class="btn-edit">Edit</button>
                    <button type="button" class="btn-hapus">Hapus</button>
                </td>
            `;
        }

        tbody.appendChild(row);
    });
}

// ===============================
// HAPUS DATA
// ===============================
function initHapusConfirm() {
    document.addEventListener("click", function (event) {
        const tombol = event.target.closest(".btn-hapus");

        if (!tombol) return;

        const row = tombol.closest("tr");

        if (!row) return;

        if (!confirm("Apakah kamu yakin ingin menghapus data ini?")) {
            return;
        }

        const halamanBuku = window.location.pathname.includes("/buku/");
        const halamanAnggota = window.location.pathname.includes("/anggota/");

        if (!halamanBuku && !halamanAnggota) {
            row.remove();
            return;
        }

        const key = halamanBuku ? "daftarBuku" : "daftarAnggota";
        const keyHapus = "dataDihapus_" + key;

        // Hapus data yang ditambahkan melalui form.
        if (row.dataset.localId) {
            const data = JSON.parse(
                localStorage.getItem(key) || "[]"
            );

            const dataBaru = data.filter(function (item) {
                return String(item.id) !== String(row.dataset.localId);
            });

            localStorage.setItem(key, JSON.stringify(dataBaru));
            row.remove();
            return;
        }

        // Simpan tanda hapus untuk data bawaan HTML.
        const nilaiBaris = Array.from(row.querySelectorAll("td"))
            .slice(0, -1)
            .map(function (td) {
                return td.textContent.trim();
            });

        const dataDihapus = JSON.parse(
            localStorage.getItem(keyHapus) || "[]"
        );

        const identitasBaris = JSON.stringify(nilaiBaris);

        if (!dataDihapus.includes(identitasBaris)) {
            dataDihapus.push(identitasBaris);
            localStorage.setItem(
                keyHapus,
                JSON.stringify(dataDihapus)
            );
        }

        row.remove();
    });
}

// ===============================
// PENCARIAN TABEL
// ===============================
function initTableFilter() {
    const filter = document.querySelector("#filter-tabel");

    if (!filter) return;

    filter.addEventListener("input", function () {
        const kataKunci = filter.value.toLowerCase();
        const rows = document.querySelectorAll(
            ".table-responsive tbody tr"
        );

        rows.forEach(function (row) {
            const teksBaris = row.textContent.toLowerCase();

            row.style.display = teksBaris.includes(kataKunci)
                ? ""
                : "none";
        });
    });
}

// ===============================
// MENCEGAH INPUT DITAMPILKAN SEBAGAI HTML
// ===============================
function escapeHTML(nilai) {
    return String(nilai ?? "").replace(/[&<>"']/g, function (karakter) {
        const karakterHTML = {
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#039;"
        };

        return karakterHTML[karakter];
    });
}
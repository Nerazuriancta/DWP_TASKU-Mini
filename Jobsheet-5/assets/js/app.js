
/* === Hamburger menu === */
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");

    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

/* === Konfirmasi hapus === */

function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return;

        const row = btn.closest("tr");
        if (!row) return;

        const halamanBuku = window.location.pathname.includes("/buku/");
        const jenis = halamanBuku ? "daftarBuku" : "daftarAnggota";
        const nama = row.querySelector("td")?.textContent || "data ini";

        if (!confirm('Yakin ingin menghapus "' + nama + '"?')) return;

        const id = row.dataset.localId;

        if (id) {
            // Hapus data baru dari localStorage.
            const data = JSON.parse(localStorage.getItem(jenis) || "[]");
            localStorage.setItem(
                jenis,
                JSON.stringify(data.filter(item => String(item.id) !== id))
            );
        } else {
            // Tandai data awal HTML sebagai sudah dihapus.
            const keyHapus = "dataDihapus_" + jenis;
            const dihapus = JSON.parse(localStorage.getItem(keyHapus) || "[]");

            const nilaiBaris = Array.from(row.querySelectorAll("td"))
                .slice(0, -1)
                .map(td => td.textContent.trim());

            dihapus.push(JSON.stringify(nilaiBaris));
            localStorage.setItem(keyHapus, JSON.stringify(dihapus));
        }

        row.remove();
    });
}

/* === Filter/pencarian tabel === */
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");

    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();

        table.querySelectorAll("tbody tr").forEach(function (row) {
            row.style.display = row.textContent.toLowerCase().includes(keyword)
                ? ""
                : "none";
        });
    });
}

/* === Validasi form === */
function tampilkanError(input, pesan) {
    hapusError(input);

    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;

    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const judul = form.querySelector("[name='judul'], [name='nama']");

        if (judul && judul.value.trim() === "") {
            tampilkanError(judul, "Field ini wajib diisi.");
            valid = false;
        } else if (judul) {
            hapusError(judul);
        }

        const pengarang = form.querySelector("[name='pengarang']");

        if (pengarang && pengarang.value.trim() === "") {
            tampilkanError(pengarang, "Pengarang wajib diisi.");
            valid = false;
        } else if (pengarang) {
            hapusError(pengarang);
        }

        const tahun = form.querySelector("[name='tahun']");

        if (tahun) {
            const nilai = Number(tahun.value);

            if (tahun.value === "" || !Number.isInteger(nilai) ||
                nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        const stok = form.querySelector("[name='stok']");

        if (stok) {
            const nilai = Number(stok.value);

            if (stok.value === "" || !Number.isInteger(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok harus berupa angka 0 atau lebih.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        if (!valid) {
            e.preventDefault();
            return;
        }

        // Simpan buku baru.
        if (form.querySelector("[name='judul']")) {
            e.preventDefault();

            const buku = {
                id: Date.now(),
                judul: form.querySelector("[name='judul']").value.trim(),
                pengarang: form.querySelector("[name='pengarang']").value.trim(),
                tahun: form.querySelector("[name='tahun']").value,
                isbn: form.querySelector("[name='isbn']").value.trim(),
                stok: form.querySelector("[name='stok']").value,
                kategori: form.querySelector("[name='kategori']").value
            };

            const data = JSON.parse(localStorage.getItem("daftarBuku") || "[]");
            data.push(buku);
            localStorage.setItem("daftarBuku", JSON.stringify(data));

            alert("Buku berhasil disimpan!");
            window.location.href = "list.html";
            return;
        }

        // Simpan anggota baru.
        if (form.querySelector("[name='no_anggota']")) {
            e.preventDefault();

            const anggota = {
                id: Date.now(),
                no_anggota: form.querySelector("[name='no_anggota']").value.trim(),
                nama: form.querySelector("[name='nama']").value.trim(),
                alamat: form.querySelector("[name='alamat']").value.trim(),
                no_hp: form.querySelector("[name='no_hp']").value.trim()
            };

            const data = JSON.parse(localStorage.getItem("daftarAnggota") || "[]");
            data.push(anggota);
            localStorage.setItem("daftarAnggota", JSON.stringify(data));

            alert("Anggota berhasil disimpan!");
            window.location.href = "list.html";
        }
    });
}

/* === Tampilkan data localStorage di halaman daftar === */


function tampilkanDataTersimpan() {
    const path = window.location.pathname;
    const halamanBuku = path.includes("/buku/");
    const halamanAnggota = path.includes("/anggota/");

    if (!halamanBuku && !halamanAnggota) return;

    const table = document.querySelector(".table-responsive table");
    if (!table) return;

    const tbody = table.querySelector("tbody");
    if (!tbody) return;

    const jenis = halamanBuku ? "daftarBuku" : "daftarAnggota";
    const keyHapus = "dataDihapus_" + jenis;
    const dihapus = JSON.parse(localStorage.getItem(keyHapus) || "[]");

    // Sembunyikan data awal HTML yang sudah dihapus.
    tbody.querySelectorAll("tr:not([data-local-id])").forEach(function (row) {
        const nilaiBaris = Array.from(row.querySelectorAll("td"))
            .slice(0, -1)
            .map(td => td.textContent.trim());

        if (dihapus.includes(JSON.stringify(nilaiBaris))) {
            row.remove();
        }
    });

    // Tampilkan data baru dari localStorage.
    tbody.querySelectorAll("tr[data-local-id]").forEach(row => row.remove());

    const data = JSON.parse(localStorage.getItem(jenis) || "[]");

    data.forEach(function (item) {
        const row = document.createElement("tr");
        row.dataset.localId = String(item.id);

        const nilai = halamanBuku
            ? [item.judul, item.pengarang, item.tahun, item.stok]
            : [item.no_anggota, item.nama, item.alamat, item.no_hp];

        nilai.forEach(function (isi) {
            const td = document.createElement("td");
            td.textContent = isi ?? "";
            row.appendChild(td);
        });

        const tdAksi = document.createElement("td");

        const edit = document.createElement("button");
        edit.type = "button";
        edit.className = "btn-edit";
        edit.textContent = "Edit";

        const hapus = document.createElement("button");
        hapus.type = "button";
        hapus.className = "btn-hapus";
        hapus.textContent = "Hapus";

        tdAksi.append(edit, hapus);
        row.appendChild(tdAksi);
        tbody.appendChild(row);
    });
}

/* === Perbarui nomor urut === */
function aturNomor() {
    document.querySelectorAll("table tbody").forEach(function (tbody) {
        let nomor = 1;

        tbody.querySelectorAll("tr").forEach(function (row) {
            if (row.style.display === "none") return;

            const kolomPertama = row.querySelector("td");
            if (kolomPertama) {
                kolomPertama.textContent = nomor++;
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
    tampilkanDataTersimpan();
});

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
        const keyHapus = "dataDihapus_" + jenis;
        const nama = row.querySelector("td")?.textContent || "data ini";

        if (!confirm('Yakin ingin menghapus "' + nama + '"?')) return;

        const id = row.dataset.localId;

        if (id) {
            // Hapus data tambahan dari localStorage.
            const data = JSON.parse(localStorage.getItem(jenis) || "[]");

            localStorage.setItem(
                jenis,
                JSON.stringify(
                    data.filter(item => String(item.id) !== String(id))
                )
            );

            // Bersihkan status edit jika data yang diedit dihapus.
            const edit = JSON.parse(
                localStorage.getItem("dataSedangDiedit") || "null"
            );

            if (edit && String(edit.id) === String(id) && edit.key === jenis) {
                localStorage.removeItem("dataSedangDiedit");
            }
        } else {
            // Tandai data awal HTML sebagai sudah dihapus.
            const dihapus = JSON.parse(
                localStorage.getItem(keyHapus) || "[]"
            );

            const nilaiBaris = Array.from(row.querySelectorAll("td"))
                .slice(0, -1)
                .map(td => td.textContent.trim());

            const identitas = JSON.stringify(nilaiBaris);

            if (!dihapus.includes(identitas)) {
                dihapus.push(identitas);
                localStorage.setItem(keyHapus, JSON.stringify(dihapus));
            }
        }

        row.remove();
    });
}

/* === Filter/pencarian tabel === */
function initTableFilter() {
    const input = document.getElementById("search-input");
    const table = document.querySelector(".table-responsive table");

    if (!input || !table) return;

    input.addEventListener("input", function () {
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

/* === Tambah dan edit data === */
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    const edit = JSON.parse(
        localStorage.getItem("dataSedangDiedit") || "null"
    );

    const inputJudul = form.querySelector("[name='judul']");
    const inputNoAnggota = form.querySelector("[name='no_anggota']");

    const jenisForm = inputJudul
        ? "daftarBuku"
        : inputNoAnggota
            ? "daftarAnggota"
            : null;

    // Isi form secara otomatis saat membuka mode Edit.
    if (edit && edit.key === jenisForm) {
        const data = JSON.parse(localStorage.getItem(edit.key) || "[]");

        const item = data.find(
            item => String(item.id) === String(edit.id)
        );

        if (item) {
            Object.keys(item).forEach(function (namaInput) {
                const input = form.querySelector(
                    '[name="' + namaInput + '"]'
                );

                if (input) {
                    input.value = item[namaInput] ?? "";
                }
            });

            const judulHalaman = document.querySelector("h1, h2");

            if (judulHalaman) {
                judulHalaman.textContent = "Edit Data";
            }

            const tombol = form.querySelector(
                "button[type='submit'], input[type='submit']"
            );

            if (tombol) {
                if (tombol.tagName === "INPUT") {
                    tombol.value = "Simpan Perubahan";
                } else {
                    tombol.textContent = "Simpan Perubahan";
                }
            }
        }
    }

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

            if (
                tahun.value === "" ||
                !Number.isInteger(nilai) ||
                nilai < 1900 ||
                nilai > 2026
            ) {
                tampilkanError(tahun, "Tahun harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        const stok = form.querySelector("[name='stok']");

        if (stok) {
            const nilai = Number(stok.value);

            if (
                stok.value === "" ||
                !Number.isInteger(nilai) ||
                nilai < 0
            ) {
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

        if (!jenisForm) return;

        e.preventDefault();

        let item;

        // Ambil isi form buku.
        if (jenisForm === "daftarBuku") {
            item = {
                judul: form.querySelector("[name='judul']").value.trim(),
                pengarang: form.querySelector("[name='pengarang']").value.trim(),
                tahun: form.querySelector("[name='tahun']").value,
                isbn: form.querySelector("[name='isbn']").value.trim(),
                stok: form.querySelector("[name='stok']").value,
                kategori: form.querySelector("[name='kategori']").value
            };
        }

        // Ambil isi form anggota.
        if (jenisForm === "daftarAnggota") {
            item = {
                no_anggota: form.querySelector("[name='no_anggota']").value.trim(),
                nama: form.querySelector("[name='nama']").value.trim(),
                alamat: form.querySelector("[name='alamat']").value.trim(),
                no_hp: form.querySelector("[name='no_hp']").value.trim()
            };
        }

        const data = JSON.parse(
            localStorage.getItem(jenisForm) || "[]"
        );

        const dataEdit = JSON.parse(
            localStorage.getItem("dataSedangDiedit") || "null"
        );

        // MODE EDIT: ubah data lama, bukan menambah baris baru.
        if (dataEdit && dataEdit.key === jenisForm) {
            const index = data.findIndex(
                data => String(data.id) === String(dataEdit.id)
            );

            if (index !== -1) {
                data[index] = {
                    ...data[index],
                    ...item,
                    id: data[index].id
                };

                localStorage.setItem(jenisForm, JSON.stringify(data));
                localStorage.removeItem("dataSedangDiedit");

                alert("Data berhasil diperbarui!");
                window.location.href = "list.html";
                return;
            }

            alert("Data yang akan diedit tidak ditemukan.");
            localStorage.removeItem("dataSedangDiedit");
            return;
        }

        // MODE TAMBAH: simpan data baru.
        item.id = Date.now();

        data.push(item);

        localStorage.setItem(jenisForm, JSON.stringify(data));

        alert(
            jenisForm === "daftarBuku"
                ? "Buku berhasil disimpan!"
                : "Anggota berhasil disimpan!"
        );

        window.location.href = "list.html";
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

    const key = halamanBuku ? "daftarBuku" : "daftarAnggota";
    const keyHapus = "dataDihapus_" + key;
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

    // Hapus tampilan data tambahan lama sebelum menampilkannya kembali.
    tbody.querySelectorAll("tr[data-local-id]").forEach(row => row.remove());

    const data = JSON.parse(localStorage.getItem(key) || "[]");

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

/* === Tombol Edit === */
function initEditButton() {
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".btn-edit");
        if (!btn) return;

        const row = btn.closest("tr");
        if (!row) return;

        // Fitur ini mengedit data yang disimpan melalui form.
        if (!row.dataset.localId) {
            alert("Data bawaan HTML belum bisa diedit dengan fitur ini.");
            return;
        }

        const halamanBuku = window.location.pathname.includes("/buku/");
        const key = halamanBuku ? "daftarBuku" : "daftarAnggota";

        const data = JSON.parse(localStorage.getItem(key) || "[]");

        const item = data.find(
            item => String(item.id) === String(row.dataset.localId)
        );

        if (!item) {
            alert("Data tidak ditemukan.");
            return;
        }

        localStorage.setItem(
            "dataSedangDiedit",
            JSON.stringify({
                key: key,
                id: item.id
            })
        );

        window.location.href = "tambah.html";
    });
}

/* === Inisialisasi semua fitur === */
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
    tampilkanDataTersimpan();
    initEditButton();
});
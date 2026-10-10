-- Jobsheet 12: database TASKU-Mini (PostgreSQL)
-- Jalankan pada database yang sudah digunakan TASKU-Mini.
-- Tabel memakai IF NOT EXISTS supaya skrip aman dijalankan ulang.

CREATE TABLE IF NOT EXISTS mata_kuliah (
    id_matkul SERIAL PRIMARY KEY,
    nama_matkul VARCHAR(100) NOT NULL,
    dosen VARCHAR(100),
    kelas VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS tugas (
    id_tugas SERIAL PRIMARY KEY,
    id_matkul INT NOT NULL REFERENCES mata_kuliah(id_matkul) ON DELETE CASCADE,
    nama_tugas VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    deadline DATE NOT NULL,
    prioritas VARCHAR(20),
    status VARCHAR(30) NOT NULL DEFAULT 'Belum Dimulai',
    catatan TEXT
);

create table mata_kuliah (
    id_matkul SERIAL primary key,
    nama_matkul VARCHAR(100) not null,
    dosen VARCHAR(100),
    kelas VARCHAR(20)
);

CREATE TABLE tugas (
    id_tugas SERIAL PRIMARY KEY,
    id_matkul INT NOT NULL REFERENCES mata_kuliah(id_matkul) ON DELETE CASCADE,
    nama_tugas VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    deadline DATE NOT NULL,
    prioritas VARCHAR(20),
    status VARCHAR(30) NOT NULL,
    catatan TEXT
);
-- Jobsheet 12: tabel pengguna untuk autentikasi TASKU-Mini.
-- Password disimpan dalam bentuk hash dari password_hash().

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'petugas'
);

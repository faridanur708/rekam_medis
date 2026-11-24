CREATE DATABASE db_rekam_medis;
USE db_rekam_medis;

CREATE TABLE pasien (
    id_pasien INT AUTO_INCREMENT PRIMARY KEY,
    no_rm VARCHAR(20) NOT NULL,
    nama_pasien VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    tanggal_lahir DATE NOT NULL,
    alamat TEXT NOT NULL
);

CREATE TABLE dokter (
    id_dokter INT AUTO_INCREMENT PRIMARY KEY,
    nama_dokter VARCHAR(100) NOT NULL,
    spesialisasi VARCHAR(50) NOT NULL
);

CREATE TABLE obat (
    id_obat INT AUTO_INCREMENT PRIMARY KEY,
    nama_obat VARCHAR(100) NOT NULL,
    satuan VARCHAR(30) NOT NULL,
    stok INT NOT NULL
);

CREATE TABLE rekam_medis (
    id_rekam INT AUTO_INCREMENT PRIMARY KEY,
    id_pasien INT NOT NULL,
    id_dokter INT NOT NULL,
    id_obat INT NOT NULL,
    tanggal_periksa DATE NOT NULL,
    keluhan TEXT NOT NULL,
    diagnosa TEXT NOT NULL,
    tindakan TEXT NOT NULL,
    resep VARCHAR(100) NOT NULL,
    FOREIGN KEY (id_pasien) REFERENCES pasien(id_pasien) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_dokter) REFERENCES dokter(id_dokter) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_obat) REFERENCES obat(id_obat) ON DELETE CASCADE ON UPDATE CASCADE
);
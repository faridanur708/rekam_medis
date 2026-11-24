<?php
$host     = "localhost";
$username = "farida";
$password = "smkn3tbn"; // Isi password jika ada
$database = "db_rekam_medis"; // Sesuaikan jika menggunakan database lain (misal: kantinku)

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
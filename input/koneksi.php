<?php
// koneksi.php
$host = "sql104.infinityfree.com"; // Server database lokal (XAMPP)
$user = "if0_42153300";      // Username default XAMPP
$pass = "tMQw1E4Cx5";          // Password default XAMPP (kosong)
$db   = "if0_42153300_cpone"; // Nama database yang sudah Anda buat di SQL

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
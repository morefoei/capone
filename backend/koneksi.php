<?php
// Koneksi database MySQL

$db_host = 'sql104.infinityfree.com';
$db_user = 'if0_42153300';
$db_pass = 'tMQw1E4Cx5';
$db_name = 'if0_42153300_cpone';

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');


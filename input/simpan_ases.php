<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm            = mysqli_real_escape_string($koneksi, $_POST['no_rm']);
    $tgl_asesmen      = mysqli_real_escape_string($koneksi, $_POST['tgl_asesmen']);
    $pemeriksa        = mysqli_real_escape_string($koneksi, $_POST['pemeriksa']);
    $keluhan_utama    = mysqli_real_escape_string($koneksi, $_POST['keluhan_utama']);
    $riwayat_sekarang = mysqli_real_escape_string($koneksi, $_POST['riwayat_sekarang']);
    $riwayat_dahulu   = mysqli_real_escape_string($koneksi, $_POST['riwayat_dahulu']);
    $alergi           = mysqli_real_escape_string($koneksi, $_POST['alergi']);
    $td               = mysqli_real_escape_string($koneksi, $_POST['td']);
    $nadi             = mysqli_real_escape_string($koneksi, $_POST['nadi']);
    $suhu             = mysqli_real_escape_string($koneksi, $_POST['suhu']);
    $pernapasan       = mysqli_real_escape_string($koneksi, $_POST['pernapasan']);
    $sat_o2           = mysqli_real_escape_string($koneksi, $_POST['sat_o2']);
    $status_generalis = mysqli_real_escape_string($koneksi, $_POST['status_generalis']);
    $diagnosis_kerja  = mysqli_real_escape_string($koneksi, $_POST['diagnosis_kerja']);
    $rencana_asuhan   = mysqli_real_escape_string($koneksi, $_POST['rencana_asuhan']);

    $sql = "INSERT INTO asesmen_awal 
                (no_rm, tgl_asesmen, pemeriksa, keluhan_utama, riwayat_sekarang,
                 riwayat_dahulu, alergi, td, nadi, suhu, pernapasan, sat_o2,
                 status_generalis, diagnosis_kerja, rencana_asuhan)
            VALUES 
                ('$no_rm', '$tgl_asesmen', '$pemeriksa', '$keluhan_utama', '$riwayat_sekarang',
                 '$riwayat_dahulu', '$alergi', '$td', '$nadi', '$suhu', '$pernapasan', '$sat_o2',
                 '$status_generalis', '$diagnosis_kerja', '$rencana_asuhan')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../form/asesmen.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: ../form/asesmen.php");
    exit();
}
?>
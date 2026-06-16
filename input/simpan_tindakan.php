<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm               = mysqli_real_escape_string($koneksi, $_POST['no_rm']);
    $tgl_tindakan        = mysqli_real_escape_string($koneksi, $_POST['tgl_tindakan']);
    $jam_tindakan        = mysqli_real_escape_string($koneksi, $_POST['jam_tindakan']);
    $pelaksana           = mysqli_real_escape_string($koneksi, $_POST['pelaksana']);
    $nama_tindakan       = mysqli_real_escape_string($koneksi, $_POST['nama_tindakan']);
    $icd9_tindakan       = mysqli_real_escape_string($koneksi, $_POST['icd9_tindakan']);
    $deskripsi_tindakan  = mysqli_real_escape_string($koneksi, $_POST['deskripsi_tindakan']);
    $bmhp                = mysqli_real_escape_string($koneksi, $_POST['bmhp'] ?? '');

    $sql = "INSERT INTO tindakan_medis 
                (no_rm, tgl_tindakan, jam_tindakan, pelaksana,
                 nama_tindakan, icd9_tindakan, deskripsi_tindakan, bmhp)
            VALUES 
                ('$no_rm', '$tgl_tindakan', '$jam_tindakan', '$pelaksana',
                 '$nama_tindakan', '$icd9_tindakan', '$deskripsi_tindakan', '$bmhp')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../form/tindakan.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: ../form/tindakan.php");
    exit();
}
?>
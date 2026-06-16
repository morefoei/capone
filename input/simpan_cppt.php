<?php
include __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm          = mysqli_real_escape_string($koneksi, $_POST['no_rm']);
    $tanggal_cppt   = mysqli_real_escape_string($koneksi, $_POST['tanggal_cppt']);
    $jam_cppt       = mysqli_real_escape_string($koneksi, $_POST['jam_cppt']);
    $profesi        = mysqli_real_escape_string($koneksi, $_POST['profesi']);
    $nama_petugas   = mysqli_real_escape_string($koneksi, $_POST['nama_petugas']);
    $subjektif      = mysqli_real_escape_string($koneksi, $_POST['subjektif']);
    $objektif       = mysqli_real_escape_string($koneksi, $_POST['objektif']);
    $asesmen        = mysqli_real_escape_string($koneksi, $_POST['asesmen']);
    $plan           = mysqli_real_escape_string($koneksi, $_POST['plan']);
    $instruksi_ppa  = mysqli_real_escape_string($koneksi, $_POST['instruksi_ppa'] ?? '');
    $verifikasi_dpjp = isset($_POST['verifikasi_dpjp']) ? 1 : 0;

    $sql = "INSERT INTO cppt 
                (no_rm, tanggal_cppt, jam_cppt, profesi, nama_petugas,
                 subjektif, objektif, asesmen, plan, instruksi_ppa, verifikasi_dpjp)
            VALUES 
                ('$no_rm', '$tanggal_cppt', '$jam_cppt', '$profesi', '$nama_petugas',
                 '$subjektif', '$objektif', '$asesmen', '$plan', '$instruksi_ppa', '$verifikasi_dpjp')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../form/cppt.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: ../form/cppt.php");
    exit();
}
?>
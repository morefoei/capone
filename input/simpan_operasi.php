<?php
include __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm            = mysqli_real_escape_string($koneksi, $_POST['no_rm']);
    $tgl_operasi      = mysqli_real_escape_string($koneksi, $_POST['tgl_operasi']);
    $jam_mulai        = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $jam_selesai      = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);
    $operator         = mysqli_real_escape_string($koneksi, $_POST['operator']);
    $asisten          = mysqli_real_escape_string($koneksi, $_POST['asisten'] ?? '');
    $dokter_anestesi  = mysqli_real_escape_string($koneksi, $_POST['dokter_anestesi']);
    $jenis_anestesi   = mysqli_real_escape_string($koneksi, $_POST['jenis_anestesi']);
    $golongan_operasi = mysqli_real_escape_string($koneksi, $_POST['golongan_operasi']);
    $diag_pra         = mysqli_real_escape_string($koneksi, $_POST['diag_pra']);
    $diag_pasca       = mysqli_real_escape_string($koneksi, $_POST['diag_pasca']);
    $tindakan         = mysqli_real_escape_string($koneksi, $_POST['tindakan']);
    $icd9             = mysqli_real_escape_string($koneksi, $_POST['icd9']);
    $laporan_narasi   = mysqli_real_escape_string($koneksi, $_POST['laporan_narasi']);
    $perdarahan       = intval($_POST['perdarahan'] ?? 0);
    $jaringan_pa      = mysqli_real_escape_string($koneksi, $_POST['jaringan_pa'] ?? '');
    $autentikasi      = isset($_POST['autentikasi']) ? 1 : 0;

    $sql = "INSERT INTO laporan_operasi 
                (no_rm, tgl_operasi, jam_mulai, jam_selesai, operator, asisten,
                 dokter_anestesi, jenis_anestesi, golongan_operasi, diag_pra,
                 diag_pasca, tindakan, icd9, laporan_narasi, perdarahan,
                 jaringan_pa, autentikasi)
            VALUES 
                ('$no_rm', '$tgl_operasi', '$jam_mulai', '$jam_selesai', '$operator', '$asisten',
                 '$dokter_anestesi', '$jenis_anestesi', '$golongan_operasi', '$diag_pra',
                 '$diag_pasca', '$tindakan', '$icd9', '$laporan_narasi', '$perdarahan',
                 '$jaringan_pa', '$autentikasi')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../form/operasi.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: ../form/operasi.php");
    exit();
}
?>
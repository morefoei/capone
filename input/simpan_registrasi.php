<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm         = mysqli_real_escape_string($koneksi, $_POST['no_rm']);
    $nik           = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $nama_pasien   = mysqli_real_escape_string($koneksi, $_POST['nama_pasien']);
    $tempat_lahir  = mysqli_real_escape_string($koneksi, $_POST['tempat_lahir']);
    $tgl_lahir     = mysqli_real_escape_string($koneksi, $_POST['tgl_lahir']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $agama         = mysqli_real_escape_string($koneksi, $_POST['agama']);
    $gol_darah     = mysqli_real_escape_string($koneksi, $_POST['gol_darah']);
    $no_hp         = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat        = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $nama_pj       = mysqli_real_escape_string($koneksi, $_POST['nama_pj']);
    $hubungan_pj   = mysqli_real_escape_string($koneksi, $_POST['hubungan_pj']);
    $cara_bayar    = mysqli_real_escape_string($koneksi, $_POST['cara_bayar']);
    $tujuan_poli   = mysqli_real_escape_string($koneksi, $_POST['tujuan_poli']);

    $sql = "INSERT INTO registrasi_pasien 
            (no_rm, nik, nama_pasien, tempat_lahir, tgl_lahir, jenis_kelamin, 
             agama, gol_darah, no_hp, alamat, nama_pj, hubungan_pj, cara_bayar, tujuan_poli)
            VALUES 
            ('$no_rm','$nik','$nama_pasien','$tempat_lahir','$tgl_lahir','$jenis_kelamin',
             '$agama','$gol_darah','$no_hp','$alamat','$nama_pj','$hubungan_pj','$cara_bayar','$tujuan_poli')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: daftar_pasien.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: registrasi.php");
    exit();
}
?>
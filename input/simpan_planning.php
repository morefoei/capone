<?php
include __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm               = mysqli_real_escape_string($koneksi, $_POST['no_rm']);
    $tgl_masuk           = mysqli_real_escape_string($koneksi, $_POST['tgl_masuk']);
    $tgl_estimasi_pulang = mysqli_real_escape_string($koneksi, $_POST['tgl_estimasi_pulang']);
    $bantuan_adl         = mysqli_real_escape_string($koneksi, $_POST['bantuan_adl']);
    $jadwal_kontrol      = mysqli_real_escape_string($koneksi, $_POST['jadwal_kontrol']);
    $edukasi_diet        = mysqli_real_escape_string($koneksi, $_POST['edukasi_diet']);
    $tanda_bahaya        = mysqli_real_escape_string($koneksi, $_POST['tanda_bahaya']);
    $petugas_edukator    = mysqli_real_escape_string($koneksi, $_POST['petugas_edukator']);
    $persetujuan_pasien  = mysqli_real_escape_string($koneksi, $_POST['persetujuan_pasien']);

    $sql = "INSERT INTO discharge_planning 
                (no_rm, tgl_masuk, tgl_estimasi_pulang, bantuan_adl,
                 jadwal_kontrol, edukasi_diet, tanda_bahaya,
                 petugas_edukator, persetujuan_pasien)
            VALUES 
                ('$no_rm', '$tgl_masuk', '$tgl_estimasi_pulang', '$bantuan_adl',
                 '$jadwal_kontrol', '$edukasi_diet', '$tanda_bahaya',
                 '$petugas_edukator', '$persetujuan_pasien')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../form/planning.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: ../form/planning.php");
    exit();
}
?>
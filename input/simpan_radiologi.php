<?php
include __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm             = mysqli_real_escape_string($koneksi, $_POST['no_rm']);
    $tgl_permintaan    = mysqli_real_escape_string($koneksi, $_POST['tgl_permintaan']);
    $dokter_pengirim   = mysqli_real_escape_string($koneksi, $_POST['dokter_pengirim']);
    $indikasi_klinis   = mysqli_real_escape_string($koneksi, $_POST['indikasi_klinis']);
    $jenis_pemeriksaan = mysqli_real_escape_string($koneksi, $_POST['jenis_pemeriksaan']);
    $file_citra        = mysqli_real_escape_string($koneksi, $_POST['file_citra']);
    $hasil_ekspertise  = mysqli_real_escape_string($koneksi, $_POST['hasil_ekspertise']);
    $kesimpulan        = mysqli_real_escape_string($koneksi, $_POST['kesimpulan']);
    $tgl_baca          = mysqli_real_escape_string($koneksi, $_POST['tgl_baca']);
    $dokter_radiologi  = mysqli_real_escape_string($koneksi, $_POST['dokter_radiologi']);
    $validasi_radiolog = isset($_POST['validasi_radiolog']) ? 1 : 0;

    $sql = "INSERT INTO radiologi 
                (no_rm, tgl_permintaan, dokter_pengirim, indikasi_klinis,
                 jenis_pemeriksaan, file_citra, hasil_ekspertise, kesimpulan,
                 tgl_baca, dokter_radiologi, validasi_radiolog)
            VALUES 
                ('$no_rm', '$tgl_permintaan', '$dokter_pengirim', '$indikasi_klinis',
                 '$jenis_pemeriksaan', '$file_citra', '$hasil_ekspertise', '$kesimpulan',
                 '$tgl_baca', '$dokter_radiologi', '$validasi_radiolog')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../form/radiologi.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: ../form/radiologi.php");
    exit();
}
?>
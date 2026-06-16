<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm           = mysqli_real_escape_string($koneksi, $_POST['no_rm']);
    $dokter_pengirim = mysqli_real_escape_string($koneksi, $_POST['dokter_pengirim']);
    $spesimen        = mysqli_real_escape_string($koneksi, $_POST['spesimen']);
    $param_1         = mysqli_real_escape_string($koneksi, $_POST['param_1'] ?? '');
    $hasil_1         = mysqli_real_escape_string($koneksi, $_POST['hasil_1'] ?? '');
    $rujukan_1       = mysqli_real_escape_string($koneksi, $_POST['rujukan_1'] ?? '');
    $satuan_1        = mysqli_real_escape_string($koneksi, $_POST['satuan_1'] ?? '');
    $param_2         = mysqli_real_escape_string($koneksi, $_POST['param_2'] ?? '');
    $hasil_2         = mysqli_real_escape_string($koneksi, $_POST['hasil_2'] ?? '');
    $rujukan_2       = mysqli_real_escape_string($koneksi, $_POST['rujukan_2'] ?? '');
    $satuan_2        = mysqli_real_escape_string($koneksi, $_POST['satuan_2'] ?? '');
    $param_3         = mysqli_real_escape_string($koneksi, $_POST['param_3'] ?? '');
    $hasil_3         = mysqli_real_escape_string($koneksi, $_POST['hasil_3'] ?? '');
    $rujukan_3       = mysqli_real_escape_string($koneksi, $_POST['rujukan_3'] ?? '');
    $satuan_3        = mysqli_real_escape_string($koneksi, $_POST['satuan_3'] ?? '');
    $param_4         = mysqli_real_escape_string($koneksi, $_POST['param_4'] ?? '');
    $hasil_4         = mysqli_real_escape_string($koneksi, $_POST['hasil_4'] ?? '');
    $rujukan_4       = mysqli_real_escape_string($koneksi, $_POST['rujukan_4'] ?? '');
    $satuan_4        = mysqli_real_escape_string($koneksi, $_POST['satuan_4'] ?? '');
    $catatan_lab     = mysqli_real_escape_string($koneksi, $_POST['catatan_lab'] ?? '');
    $tgl_otorisasi   = mysqli_real_escape_string($koneksi, $_POST['tgl_otorisasi']);
    $petugas_lab     = mysqli_real_escape_string($koneksi, $_POST['petugas_lab']);

    $sql = "INSERT INTO laboratorium 
                (no_rm, dokter_pengirim, spesimen,
                 param_1, hasil_1, rujukan_1, satuan_1,
                 param_2, hasil_2, rujukan_2, satuan_2,
                 param_3, hasil_3, rujukan_3, satuan_3,
                 param_4, hasil_4, rujukan_4, satuan_4,
                 catatan_lab, tgl_otorisasi, petugas_lab)
            VALUES 
                ('$no_rm', '$dokter_pengirim', '$spesimen',
                 '$param_1', '$hasil_1', '$rujukan_1', '$satuan_1',
                 '$param_2', '$hasil_2', '$rujukan_2', '$satuan_2',
                 '$param_3', '$hasil_3', '$rujukan_3', '$satuan_3',
                 '$param_4', '$hasil_4', '$rujukan_4', '$satuan_4',
                 '$catatan_lab', '$tgl_otorisasi', '$petugas_lab')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../form/lab.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: ../form/lab.php");
    exit();
}
?>
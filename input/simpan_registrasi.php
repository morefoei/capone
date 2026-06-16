<?php
include __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm_lama    = mysqli_real_escape_string($koneksi, $_POST['no_rm_lama']);
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

    $sql = "UPDATE registrasi_pasien SET
                nik='$nik', nama_pasien='$nama_pasien', tempat_lahir='$tempat_lahir',
                tgl_lahir='$tgl_lahir', jenis_kelamin='$jenis_kelamin', agama='$agama',
                gol_darah='$gol_darah', no_hp='$no_hp', alamat='$alamat',
                nama_pj='$nama_pj', hubungan_pj='$hubungan_pj',
                cara_bayar='$cara_bayar', tujuan_poli='$tujuan_poli'
            WHERE no_rm='$no_rm_lama'";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: /form/registrasi?status=update");
        exit();
    } else {
        echo "Gagal update: " . mysqli_error($koneksi);
    }

} else {
    header("Location: /form/registrasi");
    exit();
}
?>
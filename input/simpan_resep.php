<?php
include __DIR__ . '/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $no_rm            = mysqli_real_escape_string($koneksi, $_POST['no_rm']);
    $dokter_resep     = mysqli_real_escape_string($koneksi, $_POST['dokter_resep']);
    $alergi           = mysqli_real_escape_string($koneksi, $_POST['alergi']);
    $obat_1           = mysqli_real_escape_string($koneksi, $_POST['obat_1']);
    $qty_1            = intval($_POST['qty_1']);
    $signa_1          = mysqli_real_escape_string($koneksi, $_POST['signa_1']);
    $obat_2           = mysqli_real_escape_string($koneksi, $_POST['obat_2'] ?? '');
    $qty_2            = intval($_POST['qty_2'] ?? 0);
    $signa_2          = mysqli_real_escape_string($koneksi, $_POST['signa_2'] ?? '');
    $obat_3           = mysqli_real_escape_string($koneksi, $_POST['obat_3'] ?? '');
    $qty_3            = intval($_POST['qty_3'] ?? 0);
    $signa_3          = mysqli_real_escape_string($koneksi, $_POST['signa_3'] ?? '');
    $instruksi_farmasi = mysqli_real_escape_string($koneksi, $_POST['instruksi_farmasi'] ?? '');
    $e_sign_dokter    = isset($_POST['e_sign_dokter']) ? 1 : 0;

    $sql = "INSERT INTO e_resep 
                (no_rm, dokter_resep, alergi,
                 obat_1, qty_1, signa_1,
                 obat_2, qty_2, signa_2,
                 obat_3, qty_3, signa_3,
                 instruksi_farmasi, e_sign_dokter)
            VALUES 
                ('$no_rm', '$dokter_resep', '$alergi',
                 '$obat_1', '$qty_1', '$signa_1',
                 '$obat_2', '$qty_2', '$signa_2',
                 '$obat_3', '$qty_3', '$signa_3',
                 '$instruksi_farmasi', '$e_sign_dokter')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: ../form/resep.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menyimpan: " . mysqli_error($koneksi);
    }

} else {
    header("Location: ../form/resep.php");
    exit();
}
?>
<?php
// simpan.php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Menangkap data dari form
    $no_rm = $_POST['no_rm'];
    $nama_pasien = $_POST['nama_pasien'];
    $dpjp = $_POST['dpjp'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $tgl_pulang = $_POST['tgl_pulang'];
    $diagnosis_utama = $_POST['diagnosis_utama'];
    $kode_icd10 = $_POST['kode_icd10'];
    $tindakan = $_POST['tindakan'];
    $kode_icd9 = $_POST['kode_icd9'];
    $terapi_pulang = $_POST['terapi_pulang'];
    $autentikasi = isset($_POST['autentikasi']) ? 1 : 0;

    // Simpan data ke tabel resume_medis
    $query = "INSERT INTO resume_medis 
              (no_rm, dpjp, tgl_masuk, tgl_pulang, diagnosis_utama, kode_icd10_utama, tindakan, kode_icd9cm, terapi_pulang, autentikasi_dokter) 
              VALUES 
              ('$no_rm', '$dpjp', '$tgl_masuk', '$tgl_pulang', '$diagnosis_utama', '$kode_icd10', '$tindakan', '$kode_icd9', '$terapi_pulang', '$autentikasi')";

    if (mysqli_query($koneksi, $query)) {
        // MENGAMBIL ID RESUME YANG BARU SAJA DISIMPAN
        $id_resume_baru = mysqli_insert_id($koneksi);

        // MENGALIHKAN (REDIRECT) KE HALAMAN CETAK
        // Kita mengirimkan id_resume dan nama_pasien ke URL file cetak.php
        header("Location: /cetak/" . $id_resume_baru . "/" . urlencode($nama_pasien));
        exit(); // Hentikan script setelah redirect
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
    
    mysqli_close($koneksi);
}
?>
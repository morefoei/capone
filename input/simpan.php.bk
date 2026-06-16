<?php
// --- Tambahkan 3 baris ini untuk memunculkan pesan error jika ada ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// simpan.php
include 'koneksi.php';

// Jika diakses melalui Form (POST)
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
        header("Location: /cetak/" . $id_resume_baru . "/" . urlencode($nama_pasien));
        exit(); 
    } else {
        // Jika gagal query, tampilkan alasannya
        echo "<h3>Gagal menyimpan ke database!</h3>";
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
    
    mysqli_close($koneksi);

} else {
    // INI YANG SEBELUMNYA TIDAK ADA:
    // Jika diakses langsung atau kena redirect dari InfinityFree (?i=1)
    echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif;'>";
    echo "<h2>Akses Ditolak atau Form Kosong!</h2>";
    echo "<p>Sistem mendeteksi Anda mengakses halaman ini secara langsung tanpa mengirim data.</p>";
    echo "<p>Jika Anda merasa sudah mengisi form, ini mungkin karena sistem keamanan hosting memblokirnya. Silakan kembali dan coba klik Simpan lagi.</p>";
    echo "<a href='/form' style='padding: 10px 20px; background: #0d6efd; color: white; text-decoration: none; border-radius: 5px;'>Kembali ke Form</a>";
    echo "</div>";
}
?>
<?php
$pesan = "";

// Konfigurasi Database (Sesuaikan dengan settingan XAMPP/Hosting kamu)
$host = "localhost";
$user = "root";       // Default XAMPP
$pass = "";           // Default XAMPP (kosong)
$db   = "capstone_rmik"; // Nama database

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Jika tombol simpan ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_dokter = mysqli_real_escape_string($conn, $_POST['nama_dokter']);
    $nomor_dokter = mysqli_real_escape_string($conn, $_POST['nomor_dokter']);
    $jenis_dokter = mysqli_real_escape_string($conn, $_POST['jenis_dokter']);
    
    // Proses Upload File Tanda Tangan
    if (isset($_FILES['file_ttd']) && $_FILES['file_ttd']['error'] == 0) {
        $file_name = $_FILES['file_ttd']['name'];
        $file_tmp = $_FILES['file_ttd']['tmp_name'];
        
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        
        if (in_array($file_ext, $allowed_ext)) {
            $upload_dir = 'uploads/ttd/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Nama file baru
            $new_file_name = 'ttd_' . preg_replace('/[^A-Za-z0-9\-]/', '', $nomor_dokter) . '.' . $file_ext;
            $destination = $upload_dir . $new_file_name;
            
            // Cek apakah nomor dokter sudah ada di database (karena nomor dokter itu unik)
            $cek_nomor = mysqli_query($conn, "SELECT nomor_dokter FROM dokter WHERE nomor_dokter = '$nomor_dokter'");
            
            if (mysqli_num_rows($cek_nomor) > 0) {
                $pesan = "<div class='alert alert-warning'>Nomor Dokter (SIP/NIP) <b>$nomor_dokter</b> sudah terdaftar!</div>";
            } else {
                // Pindahkan file & Simpan ke database
                if (move_uploaded_file($file_tmp, $destination)) {
                    
                    // Query Insert ke Database
                    $query = "INSERT INTO dokter (nama_dokter, nomor_dokter, jenis_dokter, file_ttd) 
                              VALUES ('$nama_dokter', '$nomor_dokter', '$jenis_dokter', '$new_file_name')";
                              
                    if (mysqli_query($conn, $query)) {
                        $pesan = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <strong>Berhasil!</strong> Data dokter <b>$nama_dokter</b> berhasil disimpan ke database.
                                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                  </div>";
                    } else {
                        $pesan = "<div class='alert alert-danger'>Gagal menyimpan ke database: " . mysqli_error($conn) . "</div>";
                    }
                    
                } else {
                    $pesan = "<div class='alert alert-danger'>Gagal memindahkan file tanda tangan ke folder server.</div>";
                }
            }
        } else {
            $pesan = "<div class='alert alert-warning'>Format file ditolak! Hanya diperbolehkan .JPG, .JPEG, dan .PNG.</div>";
        }
    } else {
        $pesan = "<div class='alert alert-danger'>Harap pilih file gambar tanda tangan.</div>";
    }
}
?>
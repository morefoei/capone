<?php
// Nyalakan error reporting sementara biar kalau ada salah ketik langsung kelihatan pesannya
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Panggil file koneksi (pastikan path-nya benar sesuai struktur foldermu)
require_once '../input/koneksi.php'; 

$pesan = "";
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// ==========================================
// PROSES SIMPAN (TAMBAH BARU) ATAU UPDATE
// ==========================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // SEMUA $conn DIUBAH MENJADI $koneksi SESUAI FILE koneksi.php KAMU
    $id_dokter = isset($_POST['id_dokter']) ? mysqli_real_escape_string($koneksi, $_POST['id_dokter']) : '';
    $nama_dokter = mysqli_real_escape_string($koneksi, $_POST['nama_dokter']);
    $nomor_dokter = mysqli_real_escape_string($koneksi, $_POST['nomor_dokter']);
    $jenis_dokter = mysqli_real_escape_string($koneksi, $_POST['jenis_dokter']);
    
    // Default file name (kosong jika tidak ada upload)
    $new_file_name = "";
    $upload_sukses = true;

    // Cek apakah ada file yang diupload (baik saat tambah atau edit)
    if (isset($_FILES['file_ttd']) && $_FILES['file_ttd']['error'] == 0) {
        $file_name = $_FILES['file_ttd']['name'];
        $file_tmp = $_FILES['file_ttd']['tmp_name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        
        if (in_array($file_ext, $allowed_ext)) {
            $upload_dir = 'uploads/ttd/';
            if (!is_dir($upload_dir)) { mkdir($upload_dir, 0777, true); }
            
            $new_file_name = 'ttd_' . preg_replace('/[^A-Za-z0-9\-]/', '', $nomor_dokter) . '.' . $file_ext;
            $destination = $upload_dir . $new_file_name;
            
            if (!move_uploaded_file($file_tmp, $destination)) {
                $upload_sukses = false;
                $pesan = "<div class='alert alert-danger'>Gagal memindahkan file tanda tangan ke folder server.</div>";
            }
        } else {
            $upload_sukses = false;
            $pesan = "<div class='alert alert-warning'>Format file ditolak! Hanya .JPG, .JPEG, dan .PNG.</div>";
        }
    }

    // Jika proses upload tidak bermasalah
    if ($upload_sukses) {
        if (empty($id_dokter)) {
            // --- PROSES INSERT (TAMBAH BARU) ---
            if (empty($new_file_name)) {
                $pesan = "<div class='alert alert-danger'>Tanda tangan wajib diupload untuk dokter baru!</div>";
            } else {
                $cek_nomor = mysqli_query($koneksi, "SELECT nomor_dokter FROM dokter WHERE nomor_dokter = '$nomor_dokter'");
                if (mysqli_num_rows($cek_nomor) > 0) {
                    $pesan = "<div class='alert alert-warning'>Nomor Dokter <b>$nomor_dokter</b> sudah terdaftar!</div>";
                } else {
                    $query = "INSERT INTO dokter (nama_dokter, nomor_dokter, jenis_dokter, file_ttd) 
                              VALUES ('$nama_dokter', '$nomor_dokter', '$jenis_dokter', '$new_file_name')";
                    if (mysqli_query($koneksi, $query)) {
                        $pesan = "<div class='alert alert-success'>Data dokter berhasil ditambahkan!</div>";
                        $action = 'list'; // Kembali ke list
                    } else {
                        $pesan = "<div class='alert alert-danger'>Gagal: " . mysqli_error($koneksi) . "</div>";
                    }
                }
            }
        } else {
            // --- PROSES UPDATE (EDIT) ---
            if (!empty($new_file_name)) {
                $query = "UPDATE dokter SET nama_dokter='$nama_dokter', nomor_dokter='$nomor_dokter', jenis_dokter='$jenis_dokter', file_ttd='$new_file_name' WHERE id_dokter='$id_dokter'";
            } else {
                $query = "UPDATE dokter SET nama_dokter='$nama_dokter', nomor_dokter='$nomor_dokter', jenis_dokter='$jenis_dokter' WHERE id_dokter='$id_dokter'";
            }
            
            if (mysqli_query($koneksi, $query)) {
                $pesan = "<div class='alert alert-success'>Data dokter berhasil diperbarui!</div>";
                $action = 'list'; // Kembali ke list
            } else {
                $pesan = "<div class='alert alert-danger'>Gagal update: " . mysqli_error($koneksi) . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data DPJP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php if (file_exists('navbar.php')) include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    
    <?php if(!empty($pesan)) echo $pesan; ?>

    <?php 
    // ==========================================
    // TAMPILAN 1: DAFTAR DOKTER (LIST)
    // ==========================================
    if ($action == 'list'): 
    ?>
        <div class="d-flex justify-content-start mb-3">
            <a href="index.php" class="btn btn-warning fw-bold">Kembali ke Halaman Utama</a>
        </div>
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Dokter (DPJP)</h4>
                <a href="?action=form" class="btn btn-success fw-bold">+ Tambah Dokter</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Dokter</th>
                                <th>Nomor (SIP/NIP)</th>
                                <th>Tipe</th>
                                <th>Tanda Tangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            // Update variabel $conn jadi $koneksi di sini juga
                            $query_list = mysqli_query($koneksi, "SELECT * FROM dokter ORDER BY id_dokter DESC");
                            if(mysqli_num_rows($query_list) > 0) {
                                while($row = mysqli_fetch_assoc($query_list)) {
                                    echo "<tr>";
                                    echo "<td>{$no}</td>";
                                    echo "<td class='fw-bold'>{$row['nama_dokter']}</td>";
                                    echo "<td>{$row['nomor_dokter']}</td>";
                                    echo "<td>{$row['jenis_dokter']}</td>";
                                    echo "<td><a href='uploads/ttd/{$row['file_ttd']}' target='_blank' class='btn btn-sm btn-outline-info'>Lihat TTD</a></td>";
                                    echo "<td>
                                            <a href='?action=form&id={$row['id_dokter']}' class='btn btn-sm btn-warning'>✏️ Edit</a>
                                          </td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center text-muted'>Belum ada data dokter terdaftar.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php 
    // ==========================================
    // TAMPILAN 2: FORM TAMBAH & EDIT DOKTER
    // ==========================================
    else: 
        // Cek apakah mode edit
        $id_edit = isset($_GET['id']) ? $_GET['id'] : '';
        $data_edit = null;
        
        if (!empty($id_edit)) {
            // Update variabel $conn jadi $koneksi
            $query_edit = mysqli_query($koneksi, "SELECT * FROM dokter WHERE id_dokter = '$id_edit'");
            $data_edit = mysqli_fetch_assoc($query_edit);
        }
    ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header <?= $data_edit ? 'bg-warning' : 'bg-primary' ?> text-white">
                        <h4 class="mb-0"><?= $data_edit ? '✏️ Edit Data Dokter' : '➕ Tambah Data Dokter' ?></h4>
                    </div>
                    <div class="card-body">
                        <form action="?action=form<?= $data_edit ? '&id='.$id_edit : '' ?>" method="POST" enctype="multipart/form-data">
                            
                            <input type="hidden" name="id_dokter" value="<?= $data_edit ? $data_edit['id_dokter'] : '' ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Dokter <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_dokter" placeholder="Misal: dr. Budi Santoso, Sp.PD" value="<?= $data_edit ? $data_edit['nama_dokter'] : '' ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Dokter (SIP/NIP) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_dokter" placeholder="Masukkan nomor SIP atau NIP" value="<?= $data_edit ? $data_edit['nomor_dokter'] : '' ?>" required <?= $data_edit ? 'readonly' : '' ?>>
                                <?php if($data_edit) echo "<small class='text-muted'>Nomor dokter tidak dapat diubah.</small>"; ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipe Dokter <span class="text-danger">*</span></label>
                                <select class="form-select" name="jenis_dokter" required>
                                    <option value="" disabled <?= !$data_edit ? 'selected' : '' ?>>-- Pilih Tipe Dokter --</option>
                                    <option value="Dokter Umum" <?= ($data_edit && $data_edit['jenis_dokter'] == 'Dokter Umum') ? 'selected' : '' ?>>Dokter Umum</option>
                                    <option value="Dokter Spesialis" <?= ($data_edit && $data_edit['jenis_dokter'] == 'Dokter Spesialis') ? 'selected' : '' ?>>Dokter Spesialis</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Upload Tanda Tangan <?= !$data_edit ? '<span class="text-danger">*</span>' : '' ?></label>
                                <input type="file" class="form-control" name="file_ttd" accept=".jpg, .jpeg, .png" <?= !$data_edit ? 'required' : '' ?>>
                                <div class="form-text text-muted">
                                    Format: <b>JPG / PNG</b>. 
                                    <?php if($data_edit) echo "<br><span class='text-primary'>Kosongkan jika tidak ingin mengubah gambar tanda tangan saat ini.</span>"; ?>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="?action=list" class="btn btn-secondary">Batal / Kembali</a>
                                <button type="submit" class="btn <?= $data_edit ? 'btn-warning' : 'btn-success' ?> fw-bold px-4">
                                    💾 <?= $data_edit ? 'Update Data' : 'Simpan Data' ?>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
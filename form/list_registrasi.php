<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    

include dirname(__DIR__) . '/backend/koneksi.php';
include __DIR__ . '/registrasi_helpers.php';

ensureRegistrasiSchema($koneksi);

$isAdmin = true;

if (isset($_GET['action']) && $_GET['action'] === 'delete_reg' && isset($_GET['id']) && $isAdmin) {
    $delId = (int)$_GET['id'];
    
    // Cari semua E-Resume yang menempel pada Registrasi ini
    $resQuery = mysqli_query($koneksi, "SELECT id FROM tabel_resume_medis WHERE registrasi_id = $delId");
    if ($resQuery) {
        while($rowRes = mysqli_fetch_assoc($resQuery)) {
            $resId = (int)$rowRes['id'];
            mysqli_query($koneksi, "DELETE FROM tabel_resume_icd WHERE resume_id = $resId");
        }
    }
    
    // Hapus E-Resume terkait
    mysqli_query($koneksi, "DELETE FROM tabel_resume_medis WHERE registrasi_id = $delId");
    
    // Hapus Registrasi
    if (mysqli_query($koneksi, "DELETE FROM tabel_registrasi WHERE id = $delId")) {
        echo "<script>alert('Data registrasi berhasil dihapus secara permanen.'); window.location.href='/form/list_registrasi';</script>";
        exit;
    } else {
        $error = mysqli_error($koneksi);
        echo "<script>alert('Gagal menghapus: $error'); window.location.href='/form/list_registrasi';</script>";
        exit;
    }
}

$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$registrasiSql = "SELECT r.*, tr.id AS resume_id
                  FROM tabel_registrasi r
                  LEFT JOIN (
                      SELECT registrasi_id, MAX(id) AS id
                      FROM tabel_resume_medis
                      WHERE registrasi_id IS NOT NULL
                      GROUP BY registrasi_id
                  ) tr ON tr.registrasi_id = r.id
                  ORDER BY r.id DESC LIMIT $limit OFFSET $offset";
$registrasiResult = mysqli_query($koneksi, $registrasiSql);

$totalRegResult = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tabel_registrasi");
$totalReg = mysqli_fetch_assoc($totalRegResult)['total'];
$totalPages = ceil($totalReg / $limit);

if (!$registrasiResult) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Registrasi Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<?php include dirname(__DIR__) . '/navbar.php'; ?>

<div class="container mt-5">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <img src="/assets/img/logo-ueu-unggul.png" alt="Logo Esa Unggul" height="40" class="me-3">
                <div>
                    <h3 class="mb-1">Data Registrasi Pasien</h3>
                    <p class="text-muted mb-0">Daftar semua pasien yang telah diregistrasi.</p>
                </div>
            </div>
            <div>
                <a href="/" class="btn btn-outline-dark shadow-sm me-2">
                    Kembali ke Index
                </a>
                <a href="/form/registrasi" class="btn btn-primary shadow-sm me-2">
                    Buat Registrasi Baru
                </a>
            </div>
        </div>

        <div class="section-heading">List Registrasi</div>
        <div class="table-responsive mb-4">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>NRM</th>
                        <th>Nama Pasien</th>
                        <th>Tgl Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Tgl Masuk</th>
                        <th>Penyakit</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($registrasiResult) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($registrasiResult)): ?>
                            <?php
                            $tglLahir = !empty($row['tanggal_lahir']) ? date('d-M-Y', strtotime($row['tanggal_lahir'])) : '-';
                            $tglMasuk = !empty($row['tgl_masuk']) ? date('d-M-Y', strtotime($row['tgl_masuk'])) : '-';
                            ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($row['nomor_rm'] ?? '-') ?></span></td>
                                <td><?= htmlspecialchars($row['nama_pasien'] ?? '-') ?></td>
                                <td><?= $tglLahir ?></td>
                                <td><?= htmlspecialchars($row['jenis_kelamin'] ?? '-') ?></td>
                                <td><?= $tglMasuk ?></td>
                                <td><?= htmlspecialchars($row['penyakit'] ?? '-') ?></td>
                                <td>
                                    <?php if (!empty($row['resume_id'])): ?>
                                        <span class="badge bg-success">Sudah E-Resume</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Belum E-Resume</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['resume_id'])): ?>
                                        <a href="/form/detail_resume?id=<?= (int) $row['resume_id'] ?>" class="btn btn-sm btn-outline-primary mb-1">Lihat E-Resume</a>
                                    <?php else: ?>
                                        <a href="/form/tambah_resume?registrasi_id=<?= (int) $row['id'] ?>" class="btn btn-sm btn-primary mb-1">Buat E-Resume</a>
                                    <?php endif; ?>
                                    
                                    <a href="/form/registrasi?action=edit&id=<?= (int) $row['id'] ?>&redirect=list_registrasi" class="btn btn-sm btn-outline-warning mb-1">Edit</a>

                                    <a href="/form/list_registrasi?action=delete_reg&id=<?= (int) $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus Registrasi? Data E-Resume terkait juga akan ikut terhapus!');">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">Belum ada data registrasi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pasien - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<?php
include __DIR__ . '/../input/koneksi.php';

// Notifikasi status
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'berhasil') {
        echo '<div class="alert alert-success alert-dismissible fade show mx-4 mt-3" role="alert">
                <strong>Berhasil!</strong> Data pasien berhasil disimpan.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    } elseif ($_GET['status'] === 'update') {
        echo '<div class="alert alert-info alert-dismissible fade show mx-4 mt-3" role="alert">
                <strong>Berhasil!</strong> Data pasien berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
    }
}

// Ambil data untuk edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $no_rm_edit = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $result_edit = mysqli_query($koneksi, "SELECT * FROM registrasi_pasien WHERE no_rm='$no_rm_edit'");
    $edit_data = mysqli_fetch_assoc($result_edit);
}

// Ambil semua data pasien
$result = mysqli_query($koneksi, "SELECT * FROM registrasi_pasien ORDER BY no_rm ASC");
?>

<div class="container mt-4 mb-5">

    <!-- LIST PASIEN -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pasien Terdaftar</h5>
            <button class="btn btn-warning btn-sm fw-bold" onclick="toggleForm()">+ Daftarkan Pasien Baru</button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>NIK</th>
                            <th>Tgl Lahir</th>
                            <th>No. HP</th>
                            <th>Cara Bayar</th>
                            <th>Tujuan Poli</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['no_rm']) ?></td>
                                <td><?= htmlspecialchars($row['nama_pasien']) ?></td>
                                <td><?= htmlspecialchars($row['nik']) ?></td>
                                <td><?= htmlspecialchars($row['tgl_lahir']) ?></td>
                                <td><?= htmlspecialchars($row['no_hp']) ?></td>
                                <td><?= htmlspecialchars($row['cara_bayar']) ?></td>
                                <td><?= htmlspecialchars($row['tujuan_poli']) ?></td>
                                <td>
                                    <a href="?edit=<?= urlencode($row['no_rm']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center text-muted py-3">Belum ada pasien terdaftar.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FORM DAFTAR / EDIT -->
    <div class="card shadow" id="formSection" style="display: <?= $edit_data ? 'block' : 'none' ?>;">
        <div class="card-header text-white <?= $edit_data ? 'bg-warning' : 'bg-primary' ?>">
            <h5 class="mb-0"><?= $edit_data ? 'Edit Data Pasien: ' . htmlspecialchars($edit_data['no_rm']) : 'Formulir Registrasi Pasien Baru' ?></h5>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= $edit_data ? '../input/update_registrasi.php' : '../input/simpan_registrasi.php' ?>">

                <?php if ($edit_data): ?>
                    <input type="hidden" name="no_rm_lama" value="<?= htmlspecialchars($edit_data['no_rm']) ?>">
                <?php endif; ?>

                <h5 class="border-bottom pb-2 text-primary">A. Identitas Sosial (Demografi)</h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No. Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" placeholder="Misal: 00-12-34-56"
                            value="<?= $edit_data ? htmlspecialchars($edit_data['no_rm']) : '' ?>"
                            <?= $edit_data ? 'readonly' : '' ?> required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nik" minlength="16" maxlength="16" placeholder="16 Digit KTP"
                            value="<?= $edit_data ? htmlspecialchars($edit_data['nik']) : '' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_pasien" placeholder="Sesuai KTP"
                            value="<?= $edit_data ? htmlspecialchars($edit_data['nama_pasien']) : '' ?>" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tempat_lahir"
                            value="<?= $edit_data ? htmlspecialchars($edit_data['tempat_lahir']) : '' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_lahir"
                            value="<?= $edit_data ? htmlspecialchars($edit_data['tgl_lahir']) : '' ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option value="" disabled <?= !$edit_data ? 'selected' : '' ?>>Pilih...</option>
                            <option value="Laki-laki" <?= ($edit_data && $edit_data['jenis_kelamin'] === 'Laki-laki') ? 'selected' : '' ?>>Laki-laki (L)</option>
                            <option value="Perempuan" <?= ($edit_data && $edit_data['jenis_kelamin'] === 'Perempuan') ? 'selected' : '' ?>>Perempuan (P)</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Agama <span class="text-danger">*</span></label>
                        <select class="form-select" name="agama" required>
                            <option value="" disabled <?= !$edit_data ? 'selected' : '' ?>>Pilih Agama...</option>
                            <?php foreach (['Islam','Kristen Protestan','Katolik','Hindu','Buddha','Konghucu'] as $agama): ?>
                            <option value="<?= $agama ?>" <?= ($edit_data && $edit_data['agama'] === $agama) ? 'selected' : '' ?>><?= $agama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Golongan Darah</label>
                        <select class="form-select" name="gol_darah">
                            <?php foreach (['Belum Tahu','A','B','AB','O'] as $gd): ?>
                            <option value="<?= $gd ?>" <?= ($edit_data && $edit_data['gol_darah'] === $gd) ? 'selected' : '' ?>><?= $gd ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No. HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_hp" placeholder="08123456789"
                            value="<?= $edit_data ? htmlspecialchars($edit_data['no_hp']) : '' ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="alamat" rows="2" required><?= $edit_data ? htmlspecialchars($edit_data['alamat']) : '' ?></textarea>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary">B. Penanggung Jawab & Pelayanan</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Penanggung Jawab <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_pj"
                            value="<?= $edit_data ? htmlspecialchars($edit_data['nama_pj']) : '' ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hubungan dengan Pasien <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="hubungan_pj"
                            value="<?= $edit_data ? htmlspecialchars($edit_data['hubungan_pj']) : '' ?>" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Cara Bayar <span class="text-danger">*</span></label>
                        <select class="form-select" name="cara_bayar" required>
                            <option value="" disabled <?= !$edit_data ? 'selected' : '' ?>>Pilih...</option>
                            <?php foreach (['Umum / Pribadi','BPJS Kesehatan','BPJS Ketenagakerjaan','Asuransi Swasta'] as $cb): ?>
                            <option value="<?= $cb ?>" <?= ($edit_data && $edit_data['cara_bayar'] === $cb) ? 'selected' : '' ?>><?= $cb ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tujuan Poliklinik <span class="text-danger">*</span></label>
                        <select class="form-select" name="tujuan_poli" required>
                            <option value="" disabled <?= !$edit_data ? 'selected' : '' ?>>Pilih...</option>
                            <?php foreach (['IGD','Poli Penyakit Dalam','Poli Bedah','Poli Anak','Poli Kandungan (Obgyn)','Poli Gigi'] as $poli): ?>
                            <option value="<?= $poli ?>" <?= ($edit_data && $edit_data['tujuan_poli'] === $poli) ? 'selected' : '' ?>><?= $poli ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn <?= $edit_data ? 'btn-warning' : 'btn-primary' ?> w-100 fw-bold">
                        <?= $edit_data ? 'Simpan Perubahan' : 'Daftarkan Pasien' ?>
                    </button>
                    <button type="button" class="btn btn-secondary w-25" onclick="toggleForm()">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleForm() {
    const form = document.getElementById('formSection');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
    if (form.style.display === 'block') {
        form.scrollIntoView({ behavior: 'smooth' });
    }
}
</script>
</body>
</html>
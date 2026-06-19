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

$result = mysqli_query($koneksi, "SELECT * FROM registrasi_pasien ORDER BY no_rm ASC");
?>

<div class="container mt-4 mb-5">

    <!-- LIST PASIEN -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <a href="/" class="btn btn-light btn-sm">← Kembali</a>
                <h5 class="mb-0">Daftar Pasien Terdaftar</h5>
            </div>
            <button class="btn btn-warning btn-sm fw-bold" onclick="bukaFormBaru()">+ Daftarkan Pasien Baru</button>
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
                                    <button class="btn btn-sm btn-warning" onclick="bukaFormEdit(
                                        '<?= htmlspecialchars($row['no_rm'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['nik'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['nama_pasien'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['tempat_lahir'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['tgl_lahir'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['jenis_kelamin'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['agama'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['gol_darah'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['no_hp'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['alamat'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['nama_pj'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['hubungan_pj'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['cara_bayar'], ENT_QUOTES) ?>',
                                        '<?= htmlspecialchars($row['tujuan_poli'], ENT_QUOTES) ?>'
                                    )">Edit</button>
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
    <div class="card shadow" id="formSection" style="display:none;">
        <div class="card-header text-white bg-primary" id="formHeader">
            <h5 class="mb-0" id="formTitle">Formulir Registrasi Pasien Baru</h5>
        </div>
        <div class="card-body">
            <form method="POST" id="mainForm" action="../input/simpan_registrasi.php">

                <div id="hiddenContainer"></div>

                <h5 class="border-bottom pb-2 text-primary">A. Identitas Sosial (Demografi)</h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No. Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="inputNoRM" name="no_rm" placeholder="Misal: 00-12-34-56" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nik" minlength="16" maxlength="16" placeholder="16 Digit KTP" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_pasien" placeholder="Sesuai KTP" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tempat_lahir" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_lahir" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option value="" disabled selected>Pilih...</option>
                            <option value="Laki-laki">Laki-laki (L)</option>
                            <option value="Perempuan">Perempuan (P)</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Agama <span class="text-danger">*</span></label>
                        <select class="form-select" name="agama" required>
                            <option value="" disabled selected>Pilih Agama...</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Golongan Darah</label>
                        <select class="form-select" name="gol_darah">
                            <option value="Belum Tahu">Belum Tahu</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">No. HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_hp" placeholder="08123456789" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="alamat" rows="2" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota..." required></textarea>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary">B. Penanggung Jawab & Pelayanan</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Penanggung Jawab <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_pj" placeholder="Nama Suami/Istri/Orang Tua/Keluarga" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hubungan dengan Pasien <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="hubungan_pj" placeholder="Contoh: Anak Kandung, Suami" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Cara Bayar <span class="text-danger">*</span></label>
                        <select class="form-select" name="cara_bayar" required>
                            <option value="" disabled selected>Pilih...</option>
                            <option value="Umum / Pribadi">Umum / Pribadi</option>
                            <option value="BPJS Kesehatan">BPJS Kesehatan</option>
                            <option value="BPJS Ketenagakerjaan">BPJS Ketenagakerjaan</option>
                            <option value="Asuransi Swasta">Asuransi Swasta / Perusahaan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tujuan Poliklinik <span class="text-danger">*</span></label>
                        <select class="form-select" name="tujuan_poli" required>
                            <option value="" disabled selected>Pilih...</option>
                            <option value="IGD">Instalasi Gawat Darurat (IGD)</option>
                            <option value="Poli Penyakit Dalam">Poli Penyakit Dalam</option>
                            <option value="Poli Bedah">Poli Bedah</option>
                            <option value="Poli Anak">Poli Anak</option>
                            <option value="Poli Kandungan (Obgyn)">Poli Kandungan (Obgyn)</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" id="btnSubmit" class="btn btn-primary w-100 fw-bold">Daftarkan Pasien</button>
                    <button type="button" class="btn btn-secondary w-25" onclick="tutupForm()">Batal</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const formSection     = document.getElementById('formSection');
const mainForm        = document.getElementById('mainForm');
const formHeader      = document.getElementById('formHeader');
const formTitle       = document.getElementById('formTitle');
const btnSubmit       = document.getElementById('btnSubmit');
const inputNoRM       = document.getElementById('inputNoRM');
const hiddenContainer = document.getElementById('hiddenContainer');

function bukaFormBaru() {
    mainForm.reset();
    mainForm.action = '../input/simpan_registrasi.php';
    hiddenContainer.innerHTML = '';
    inputNoRM.removeAttribute('readonly');
    formHeader.className = 'card-header text-white bg-primary';
    formTitle.textContent = 'Formulir Registrasi Pasien Baru';
    btnSubmit.className = 'btn btn-primary w-100 fw-bold';
    btnSubmit.textContent = 'Daftarkan Pasien';
    formSection.style.display = 'block';
    formSection.scrollIntoView({ behavior: 'smooth' });
}

function bukaFormEdit(no_rm, nik, nama, tempat, tgl, gender, agama, gd, hp, alamat, pj, hub, bayar, poli) {
    mainForm.reset();
    mainForm.action = '../input/update_registrasi.php';
    hiddenContainer.innerHTML = '<input type="hidden" name="no_rm_lama" value="' + no_rm + '">';

    mainForm.querySelector('[name="no_rm"]').value         = no_rm;
    mainForm.querySelector('[name="no_rm"]').setAttribute('readonly', true);
    mainForm.querySelector('[name="nik"]').value           = nik;
    mainForm.querySelector('[name="nama_pasien"]').value   = nama;
    mainForm.querySelector('[name="tempat_lahir"]').value  = tempat;
    mainForm.querySelector('[name="tgl_lahir"]').value     = tgl;
    mainForm.querySelector('[name="jenis_kelamin"]').value = gender;
    mainForm.querySelector('[name="agama"]').value         = agama;
    mainForm.querySelector('[name="gol_darah"]').value     = gd;
    mainForm.querySelector('[name="no_hp"]').value         = hp;
    mainForm.querySelector('[name="alamat"]').value        = alamat;
    mainForm.querySelector('[name="nama_pj"]').value       = pj;
    mainForm.querySelector('[name="hubungan_pj"]').value   = hub;
    mainForm.querySelector('[name="cara_bayar"]').value    = bayar;
    mainForm.querySelector('[name="tujuan_poli"]').value   = poli;

    formHeader.className = 'card-header text-white bg-warning';
    formTitle.textContent = 'Edit Data Pasien: ' + no_rm;
    btnSubmit.className = 'btn btn-warning w-100 fw-bold';
    btnSubmit.textContent = 'Simpan Perubahan';

    formSection.style.display = 'block';
    formSection.scrollIntoView({ behavior: 'smooth' });
}

function tutupForm() {
    formSection.style.display = 'none';
    mainForm.reset();
    hiddenContainer.innerHTML = '';
    inputNoRM.removeAttribute('readonly');
    mainForm.action = '../input/simpan_registrasi.php';
    formHeader.className = 'card-header text-white bg-primary';
    formTitle.textContent = 'Formulir Registrasi Pasien Baru';
    btnSubmit.className = 'btn btn-primary w-100 fw-bold';
    btnSubmit.textContent = 'Daftarkan Pasien';
}
</script>
</body>
</html>
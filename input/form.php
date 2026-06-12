<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Resume Medis - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Formulir E-Resume Medis</h4>
        </div>
        <div class="card-body">
            <form id="formEResume" action="simpan" method="POST">
                
                <h5 class="border-bottom pb-2">1. Identitas Pasien</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="noRM" name="no_rm" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Pasien <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="namaPasien" name="nama_pasien" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4">2. Detail Pelayanan</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tglMasuk" name="tgl_masuk" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Pulang <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tglPulang" name="tgl_pulang" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">DPJP <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="dpjp" name="dpjp" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4">3. Klinis & Koding</h5>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Diagnosis Utama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="diagUtama" name="diagnosis_utama" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kode ICD-10 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="icd10" name="kode_icd10" placeholder="Misal: N20.0" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Tindakan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tindakan" name="tindakan" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kode ICD-9-CM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="icd9" name="kode_icd9" placeholder="Misal: 59.8" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Terapi Pulang <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="terapi" name="terapi_pulang" rows="3" required></textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="autentikasi" name="autentikasi" value="1" required>
                    <label class="form-check-label text-success fw-bold" for="autentikasi">
                        Saya DPJP menyatakan data ini valid (Autentikasi Dokter) *
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Resume Medis</button>
            </form>
        </div>
    </div>
</div>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
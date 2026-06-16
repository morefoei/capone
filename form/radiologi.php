<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Radiologi - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <div class="d-flex justify-content-start w-100 mb-3">
                <a href="javascript:history.back()" class="btn btn-warning">
                    Kembali
                </a>
            </div>     
            <h4 class="mb-0">Formulir Pemeriksaan & Hasil Radiologi</h4>
        </div>
        <div class="card-body">
            <form id="formRadiologi" action="../input/simpan_radiologi.php" method="POST" enctype="multipart/form-data">
                
                <h5 class="border-bottom pb-2">A. Data Permintaan</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal Permintaan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_permintaan" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dokter Pengirim <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="dokter_pengirim" placeholder="Nama DPJP Pengirim" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Indikasi Klinis / Diagnosis Kerja <span class="text-danger">*</span></label>
                    <div class="form-text mt-0 mb-1">Alasan mengapa pasien memerlukan pemeriksaan radiologi ini.</div>
                    <textarea class="form-control" name="indikasi_klinis" rows="2" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Jenis Pemeriksaan <span class="text-danger">*</span></label>
                    <select class="form-select" name="jenis_pemeriksaan" required>
                        <option value="" disabled selected>Pilih modalitas radiologi...</option>
                        <option value="X-Ray Thorax (Rontgen Dada)">X-Ray Thorax (Rontgen Dada)</option>
                        <option value="X-Ray Ekstremitas (Tulang)">X-Ray Ekstremitas (Tulang)</option>
                        <option value="USG Abdomen">USG Abdomen</option>
                        <option value="CT Scan Kepala">CT Scan Kepala</option>
                        <option value="CT Scan Thorax/Abdomen">CT Scan Thorax/Abdomen</option>
                        <option value="MRI">MRI</option>
                    </select>
                </div>

                <h5 class="border-bottom pb-2 mt-5">B. Hasil Ekspertise & Berkas Citra</h5>
                
                <div class="mb-4 p-3 bg-light rounded border border-warning">
                    <label class="form-label fw-bold text-dark">📁 Unggah Foto / Citra Radiologi (X-Ray/USG/CT Scan)</label>
                    <input type="file" class="form-control" name="citra_radiologi" accept="image/*" required>
                    <div class="form-text text-danger">Format berkas yang didukung: JPG, JPEG, PNG. Maksimal ukuran: 2MB.</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold text-success">Hasil Uraian (Ekspertise) <span class="text-danger">*</span></label>
                    <div class="form-text mt-0 mb-1">Temuan medis dari citra radiologi yang dibaca oleh Dokter Spesialis Radiologi.</div>
                    <textarea class="form-control border-success" name="hasil_ekspertise" rows="5" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-primary">Kesimpulan / Kesan <span class="text-danger">*</span></label>
                    <textarea class="form-control border-primary" name="kesimpulan" rows="2" required></textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Pembacaan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_baca" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Dokter Spesialis Radiologi (Sp.Rad) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="dokter_radiologi" required>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="validasi_radiolog" value="1" required>
                    <label class="form-check-label fw-bold text-success">
                        Saya Sp.Rad menyatakan hasil ekspertise dan berkas citra ini valid *
                    </label>
                </div>

                <button type="submit" class="btn btn-dark w-100 fw-bold">Simpan Data Radiologi</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
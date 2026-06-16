<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Operasi - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow border-0">
        <div class="card-header bg-danger text-white">
            <div class="d-flex justify-content-start w-100 mb-3">
                <a href="javascript:history.back()" class="btn btn-warning">
                    Kembali
                </a>
            </div>      
            <h4 class="mb-0"><i class="fas fa-procedures me-2"></i>Laporan Operasi & Prosedur Bedah</h4>
        </div>
        <div class="card-body p-4">
            <form id="formOperasi" action="../input/simpan_operasi.php" method="POST">
                
                <h5 class="border-bottom pb-2 text-danger fw-bold"><i class="bi bi-clock-history me-2"></i>1. Administrasi Bedah</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nomor Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" placeholder="00-00-00" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Operasi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_operasi" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Jam Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="jam_mulai" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Jam Selesai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="jam_selesai" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-danger fw-bold">2. Tim Bedah & Anestesi</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dokter Operator (Ahli Bedah) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="operator" placeholder="Nama Spesialis Bedah" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Asisten Bedah / Perawat Instrumen</label>
                        <input type="text" class="form-control" name="asisten" placeholder="Nama Asisten">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dokter Anestesi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="dokter_anestesi" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jenis Anestesi <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_anestesi" required>
                            <option value="" disabled selected>Pilih jenis anestesi...</option>
                            <option value="General Anesthesia">General Anesthesia (Umum)</option>
                            <option value="Spinal Anesthesia">Spinal Anesthesia (Regional)</option>
                            <option value="Epidural Anesthesia">Epidural Anesthesia</option>
                            <option value="Lokal">Lokal</option>
                            <option value="Sedasi">Sedasi</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Golongan Operasi <span class="text-danger">*</span></label>
                        <select class="form-select" name="golongan_operasi" required>
                            <option value="Kecil">Kecil</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Besar">Besar</option>
                            <option value="Khusus">Khusus</option>
                        </select>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-danger fw-bold">3. Diagnosis & Prosedur (ICD-9-CM)</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-primary">Diagnosis Pra-Bedah <span class="text-danger">*</span></label>
                        <textarea class="form-control border-primary" name="diag_pra" rows="2" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-success">Diagnosis Pasca-Bedah <span class="text-danger">*</span></label>
                        <textarea class="form-control border-success" name="diag_pasca" rows="2" required></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-9">
                        <label class="form-label fw-bold">Nama Prosedur / Tindakan Operasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tindakan" placeholder="Contoh: Appendectomy Terbuka" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Kode ICD-9-CM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="icd9" placeholder="Misal: 47.09" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-danger fw-bold">4. Laporan Jalannya Operasi</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Laporan Temuan Intra-Operatif & Langkah Bedah <span class="text-danger">*</span></label>
                    <div class="form-text mt-0 mb-1">Jelaskan posisi pasien, insisi, eksplorasi, penanganan jaringan, hingga penutupan luka.</div>
                    <textarea class="form-control" name="laporan_narasi" rows="6" placeholder="Tuliskan detail jalannya operasi secara kronologis..." required></textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Perdarahan (Estimasi Blood Loss)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="perdarahan" placeholder="0">
                            <span class="input-group-text">cc</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Jaringan yang Dieksisi / Dikirim ke PA</label>
                        <input type="text" class="form-control" name="jaringan_pa" placeholder="Nama jaringan (Tulis 'Tidak ada' jika tidak ada)">
                    </div>
                </div>

                <div class="form-check mb-4 bg-light p-3 border rounded">
                    <input class="form-check-input ms-0 me-2" type="checkbox" name="autentikasi" value="1" required>
                    <label class="form-check-label fw-bold text-dark">
                        Saya selaku Dokter Operator menyatakan laporan operasi ini benar, akurat, dan lengkap. *
                    </label>
                </div>

                <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold shadow">
                    <i class="fas fa-save me-2"></i>Simpan Laporan Operasi
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
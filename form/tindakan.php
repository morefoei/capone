<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Tindakan Medis - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark fw-bold">
            <h4 class="mb-0">Catatan Tindakan Keperawatan / Medis Non-Bedah</h4>
        </div>
        <div class="card-body">
            <form id="formTindakan" action="simpan_tindakan.php" method="POST">
                
                <h5 class="border-bottom pb-2">Informasi Tindakan</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nomor RM <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Tindakan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_tindakan" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Jam Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="jam_tindakan" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tenaga Pelaksana <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="pelaksana" placeholder="Dokter/Perawat" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Nama Tindakan/Prosedur Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_tindakan" placeholder="Contoh: Pemasangan Kateter Urin, Debridement Luka Ringan" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Kode Prosedur (ICD-9-CM) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="icd9_tindakan" placeholder="Misal: 57.94" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Detail Narasi Tindakan & Respon Pasien <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="deskripsi_tindakan" rows="4" placeholder="Jelaskan langkah tindakan, alat yang dipasang, ukuran, cairan, dan bagaimana respon/keluhan pasien saat tindakan..." required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Alat Kesehatan / Bahan Medis Habis Pakai (BMHP) yang Digunakan</label>
                    <textarea class="form-control" name="bmhp" rows="2" placeholder="Contoh: Kassa steril, Foley Cateter No. 16, Handscoon, Spuit 10cc..."></textarea>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold text-dark">Simpan Catatan Tindakan</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
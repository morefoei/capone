<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discharge Planning - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-start w-100 mb-3">
                <a href="javascript:history.back()" class="btn btn-warning">
                    Kembali
                </a>
            </div>     
            <h4 class="mb-0">Rencana Pemulangan Pasien (Discharge Planning)</h4>
        </div>
        <div class="card-body">
            <form id="formPlanning" action="simpan_planning.php" method="POST">
                
                <h5 class="border-bottom pb-2 text-info">1. Identifikasi Awal Pemulangan</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal Masuk RS <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_masuk" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Estimasi Tanggal Pulang <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_estimasi_pulang" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-info">2. Kriteria & Edukasi Edukatif (Kebutuhan Rumah)</h5>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Bantuan Aktivitas di Rumah (ADL) <span class="text-danger">*</span></label>
                        <select class="form-select" name="bantuan_adl" required>
                            <option value="Mandiri">Mandiri Sepenuhnya</option>
                            <option value="Bantuan Parsial">Bantuan Sebagian (Minimal)</option>
                            <option value="Bantuan Total">Bantuan Total (Bedrest)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Jadwal Kontrol Poliklinik Ulang <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="jadwal_kontrol" placeholder="Misal: Poli Bedah, 7 Hari pasca pulang (20-06-2026)" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Edukasi Diet / Pembatasan Aktivitas Fisik <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="edukasi_diet" rows="2" placeholder="Contoh: Rendah garam, tidak boleh mengangkat beban berat di atas 5 kg..." required></textarea>
                </div>

                <div class="mb-3 p-3 bg-warning bg-opacity-10 border border-warning rounded">
                    <label class="form-label fw-bold text-danger">⚠️ Tanda-Tanda Bahaya (Kondisi Darurat di Rumah) <span class="text-danger">*</span></label>
                    <div class="form-text mb-2">Informasi kritis untuk keluarga agar segera membawa kembali pasien ke IGD jika terjadi kondisi berikut.</div>
                    <textarea class="form-control border-danger" name="tanda_bahaya" rows="3" placeholder="Contoh: Demam tinggi > 38.5 C, pendarahan hebat pada luka rembes, nyeri dada tidak hilang..." required></textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Petugas Edukator (PPA) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="petugas_edukator" placeholder="Nama jelas perawat/petugas" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pernyataan Keluarga / Pasien <span class="text-danger">*</span></label>
                        <select class="form-select" name="persetujuan_pasien" required>
                            <option value="Sudah Paham">Pasien/Keluarga menyatakan sudah mengerti instruksi pemulangan</option>
                            <option value="Butuh Pendampingan">Membutuhkan Homecare lanjutan</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-info w-100 fw-bold text-white">Simpan Discharge Planning</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
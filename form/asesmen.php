<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesmen Awal Medis & Keperawatan - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-start w-100 mb-3">
                <a href="javascript:history.back()" class="btn btn-warning">
                    Kembali
                </a>
            </div>  
            <h4 class="mb-0">Formulir Asesmen Awal Medis & Keperawatan (Rawat Inap/Jalan)</h4>
        </div>
        <div class="card-body">
            <form id="formAsesmen" action="../input/simpan_ases.php" method="POST">
                
                <h5 class="border-bottom pb-2 text-secondary">1. Registrasi Klinis</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal & Jam Asesmen <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="tgl_asesmen" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Pemeriksa (PPA) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="pemeriksa" placeholder="Nama Dokter / Perawat" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-secondary">2. Anamnesis (Subjektif)</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Keluhan Utama <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="keluhan_utama" rows="2" placeholder="Alasan utama pasien datang ke fasilitas kesehatan..." required></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Riwayat Penyakit Sekarang (RPS) <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="riwayat_sekarang" rows="3" placeholder="Kronologi perjalanan penyakit saat ini secara detail..." required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Riwayat Penyakit Dahulu</label>
                        <input type="text" class="form-control" name="riwayat_dahulu" placeholder="Misal: Hipertensi, Diabetes, atau Operasi sebelumnya">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Riwayat Alergi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control border-danger" name="alergi" placeholder="Sebutkan jenis obat/makanan, tulis 'Tidak Ada' jika aman" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-secondary">3. Pemeriksaan Fisik & Tanda Vital (Objektif)</h5>
                <div class="row mb-3 g-3">
                    <div class="col-md-2">
                        <label class="form-label fw-bold">TD (Tensi)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="td" placeholder="120/80">
                            <span class="input-group-text">mmHg</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">N (Nadi)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nadi" placeholder="80">
                            <span class="input-group-text">x/mnt</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">S (Suhu)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="suhu" placeholder="36.5">
                            <span class="input-group-text">°C</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">P (Pernapasan)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="pernapasan" placeholder="20">
                            <span class="input-group-text">x/mnt</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sat O2 (Saturasi Oksigen)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="sat_o2" placeholder="98">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status Generalis / Pemeriksaan Tiap Organ</label>
                    <textarea class="form-control" name="status_generalis" rows="2" placeholder="Hasil pemeriksaan kepala, leher, dada, abdomen, ekstremitas..."></textarea>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-secondary">4. Kesimpulan Asesmen & Rencana Awal</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Diagnosis Kerja (Medis) / Masalah Keperawatan <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="diagnosis_kerja" rows="2" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Rencana Tatalaksana / Asuhan Pasien Awal <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="rencana_asuhan" rows="2" placeholder="Instruksi medis awal, rencana pemeriksaan penunjang lanjutan, atau diet awal..." required></textarea>
                </div>

                <button type="submit" class="btn btn-secondary w-100 fw-bold">Simpan Hasil Asesmen Awal</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form CPPT - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css"> </head>
<body class="bg-light">

<?php include 'navbar.php'; ?> <div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <div class="d-flex justify-content-start w-100 mb-3">
                <a href="javascript:history.back()" class="btn btn-warning">
                    Kembali
                </a>
            </div>  
            <h4 class="mb-0">Catatan Perkembangan Pasien Terintegrasi (CPPT)</h4>
        </div>
        <div class="card-body">
            <form id="formCPPT" action="../input/simpan_cppt.php" method="POST">
                
                <h5 class="border-bottom pb-2 text-info">Informasi Dasar</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tanggal_cppt" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jam <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" name="jam_cppt" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Profesi / PPA <span class="text-danger">*</span></label>
                        <select class="form-select" name="profesi" required>
                            <option value="" disabled selected>Pilih Profesi Pemberi Asuhan...</option>
                            <option value="Dokter DPJP">Dokter DPJP</option>
                            <option value="Perawat">Perawat</option>
                            <option value="Bidan">Bidan</option>
                            <option value="Ahli Gizi">Ahli Gizi</option>
                            <option value="Apoteker">Apoteker</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Petugas <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_petugas" placeholder="Nama Terang & Gelar" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-info">Metode SOAP</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-bold text-primary">S - Subjektif <span class="text-danger">*</span></label>
                    <div class="form-text mt-0 mb-1">Keluhan pasien saat ini atau riwayat penyakit.</div>
                    <textarea class="form-control border-primary" name="subjektif" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-success">O - Objektif <span class="text-danger">*</span></label>
                    <div class="form-text mt-0 mb-1">Hasil pemeriksaan fisik (TTV, kesadaran) dan pemeriksaan penunjang.</div>
                    <textarea class="form-control border-success" name="objektif" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-warning">A - Asesmen <span class="text-danger">*</span></label>
                    <div class="form-text mt-0 mb-1">Kesimpulan/Diagnosis kerja atau masalah keperawatan/gizi.</div>
                    <textarea class="form-control border-warning" name="asesmen" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-danger">P - Plan <span class="text-danger">*</span></label>
                    <div class="form-text mt-0 mb-1">Rencana asuhan, tindakan medis/keperawatan, edukasi, atau terapi.</div>
                    <textarea class="form-control border-danger" name="plan" rows="3" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Instruksi PPA Termasuk Pasca Bedah (Opsional)</label>
                    <textarea class="form-control" name="instruksi_ppa" rows="2" placeholder="Instruksi untuk petugas lain, tuliskan nama jelas jika perlu..."></textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="verifikasi_dpjp" value="1">
                    <label class="form-check-label text-muted">
                        Tandai jika sudah diverifikasi oleh Dokter Penanggung Jawab Pelayanan (DPJP)
                    </label>
                </div>

                <button type="submit" class="btn btn-info w-100 text-white fw-bold">Simpan Catatan CPPT</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
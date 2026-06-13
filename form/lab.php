<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Form Laboratorium - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .bg-purple { background-color: #6f42c1; color: white; }
    </style>
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-purple">
            <div class="d-flex justify-content-start w-100 mb-3">
                <a href="javascript:history.back()" class="btn btn-warning">
                    Kembali
                </a>
            </div>     
            <h4 class="mb-0">Formulir Pemeriksaan & Hasil Laboratorium</h4>
        </div>
        <div class="card-body">
            <form id="formLab" action="simpan_lab.php" method="POST">
                
                <h5 class="border-bottom pb-2">A. Permintaan & Sampel</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dokter Pengirim <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="dokter_pengirim" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jenis Spesimen/Sampel <span class="text-danger">*</span></label>
                        <select class="form-select" name="spesimen" required>
                            <option value="" disabled selected>Pilih sampel...</option>
                            <option value="Darah Lengkap">Darah Lengkap (Whole Blood)</option>
                            <option value="Serum/Plasma">Serum / Plasma</option>
                            <option value="Urine">Urine</option>
                            <option value="Feses">Feses</option>
                            <option value="Sputum">Sputum (Dahak)</option>
                        </select>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4">B. Hasil Pemeriksaan (Klinis)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th width="30%">Nama Parameter Uji</th>
                                <th width="20%">Hasil Pemeriksaan</th>
                                <th width="25%">Nilai Rujukan / Normal</th>
                                <th width="25%">Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="param_1" value="Hemoglobin (Hb)" readonly></td>
                                <td><input type="text" class="form-control" name="hasil_1" required></td>
                                <td><input type="text" class="form-control" name="rujukan_1" value="L: 13.5 - 17.5 | P: 12.0 - 15.5" readonly></td>
                                <td><input type="text" class="form-control" name="satuan_1" value="g/dL" readonly></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" name="param_2" value="Leukosit (WBC)" readonly></td>
                                <td><input type="text" class="form-control" name="hasil_2" required></td>
                                <td><input type="text" class="form-control" name="rujukan_2" value="4.000 - 11.000" readonly></td>
                                <td><input type="text" class="form-control" name="satuan_2" value="/µL" readonly></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" name="param_3" value="Trombosit (PLT)" readonly></td>
                                <td><input type="text" class="form-control" name="hasil_3" required></td>
                                <td><input type="text" class="form-control" name="rujukan_3" value="150.000 - 450.000" readonly></td>
                                <td><input type="text" class="form-control" name="satuan_3" value="/µL" readonly></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" name="param_4" placeholder="Parameter Tambahan (Misal: GDS)"></td>
                                <td><input type="text" class="form-control" name="hasil_4"></td>
                                <td><input type="text" class="form-control" name="rujukan_4" placeholder="Nilai Rujukan"></td>
                                <td><input type="text" class="form-control" name="satuan_4" placeholder="Satuan"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan Laboratorium / Kesan Pemeriksa</label>
                    <textarea class="form-control" name="catatan_lab" rows="2" placeholder="Tulis catatan kritis jika ada hasil abnormal..."></textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal & Jam Otorisasi <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" name="tgl_otorisasi" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Analis Kesehatan / Ahli Patologi Klinik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="petugas_lab" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-purple w-100 fw-bold">Simpan & Otorisasi Hasil Lab</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
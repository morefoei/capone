<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Resep Farmasi - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .bg-teal { background-color: #20c997; color: white; }
    </style>
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-teal">
            <div class="d-flex justify-content-start w-100 mb-3">
                <a href="javascript:history.back()" class="btn btn-warning">
                    Kembali
                </a>
            </div> 
            <h4 class="mb-0">Formulir Elektronik Resep Obat (E-Resep)</h4>
        </div>
        <div class="card-body">
            <form id="formResep" action="../input/simpan_resep.php" method="POST">
                
                <h5 class="border-bottom pb-2">1. Validitas Resep & Alergi (Aspek Safety)</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Dokter Penulis Resep <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="dokter_resep" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-danger">Riwayat Alergi Obat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control border-danger" name="alergi" placeholder="Tulis 'Tidak Ada' jika pasien aman" required>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4">2. Input Daftar Obat (R/)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="40%">Nama Obat & Sediaan (Dosis)</th>
                                <th width="20%">Jumlah (Qty)</th>
                                <th width="40%">Aturan Pakai / Signa (X sehari)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" name="obat_1" placeholder="Contoh: Amoxicillin 500mg tab" required></td>
                                <td><input type="number" class="form-control" name="qty_1" placeholder="10" required></td>
                                <td><input type="text" class="form-control" name="signa_1" placeholder="3 x 1 tablet (Sesudah makan)" required></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" name="obat_2" placeholder="Contoh: Paracetamol 500mg"></td>
                                <td><input type="number" class="form-control" name="qty_2"></td>
                                <td><input type="text" class="form-control" name="signa_2" placeholder="3 x 1 tab (Bila demam)"></td>
                            </tr>
                            <tr>
                                <td><input type="text" class="form-control" name="obat_3" placeholder="Obat tambahan..."></td>
                                <td><input type="number" class="form-control" name="qty_3"></td>
                                <td><input type="text" class="form-control" name="signa_3"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Instruksi Khusus Farmasi</label>
                    <textarea class="form-control" name="instruksi_farmasi" rows="2" placeholder="Misal: Obat sirup dikocok dahulu, antibiotik harus habis..."></textarea>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="e_sign_dokter" value="1" required>
                    <label class="form-check-label fw-bold text-success">
                        Resep ini telah divalidasi secara digital melalui akun DPJP *
                    </label>
                </div>

                <button type="submit" class="btn btn-teal w-100 fw-bold">Kirim E-Resep ke Apotek</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
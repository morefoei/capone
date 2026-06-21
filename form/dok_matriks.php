<?php require_once dirname(__DIR__) . '/backend/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi - Matriks Pemetaan Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>

<?php include dirname(__DIR__) . '/navbar.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-end mb-3 d-print-none">
        <button onclick="exportPDF()" class="btn btn-danger">📄 Export PDF</button>
    </div>
    <div class="panel" id="exportContent">
        <h3 class="section-title">Matriks Pemetaan Data (Data Mapping)</h3>
        <p class="text-muted mb-4">Matriks ini menunjukkan elemen data apa saja yang di-input pada modul Pendaftaran (e-Form Registrasi) dan secara otomatis mengalir (auto-populate) ke modul E-Resume Medis sehingga dokter/petugas tidak perlu mengetik ulang identitas dasar pasien.</p>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th width="25%">Elemen Data (e-Form Registrasi)</th>
                        <th width="25%">Elemen Data Target (E-Resume)</th>
                        <th width="15%">Tipe Data</th>
                        <th width="30%">Keterangan Integrasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="text-center">1</td><td><code>nomor_rm</code></td><td><code>nomor_rm</code></td><td>VARCHAR</td><td>Dibuat otomatis saat registrasi (Auto TDF), mengalir ke E-Resume saat ID Registrasi dipilih.</td></tr>
                    <tr><td class="text-center">2</td><td><code>nama_pasien</code></td><td><code>nama_pasien</code></td><td>VARCHAR</td><td>Auto-populate (Read-only di form E-Resume)</td></tr>
                    <tr><td class="text-center">3</td><td><code>tanggal_lahir</code></td><td><code>tanggal_lahir</code></td><td>DATE</td><td>Auto-populate (Read-only di form E-Resume)</td></tr>
                    <tr><td class="text-center">4</td><td><code>jenis_kelamin</code></td><td><code>jenis_kelamin</code></td><td>ENUM('L','P')</td><td>Auto-populate (Read-only di form E-Resume)</td></tr>
                    <tr><td class="text-center">5</td><td><code>tgl_masuk</code></td><td><code>tgl_masuk</code></td><td>DATE</td><td>Auto-populate, digunakan untuk menghitung "Lama Dirawat" jika Tanggal Keluar diisi.</td></tr>
                    <tr><td class="text-center">6</td><td><code>penyakit</code></td><td><code>diagnosa_masuk</code></td><td>TEXT</td><td>Keluhan awal pasien otomatis menjadi <em>Diagnosa Masuk</em> di E-Resume.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function exportPDF() {
    let element = document.getElementById('exportContent');
    let opt = {
        margin:       10,
        filename:     'Dokumentasi_Matriks_Mapping.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
    };
    html2pdf().set(opt).from(element).save();
}
</script>
</body>
</html>

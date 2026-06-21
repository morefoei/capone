<?php require_once dirname(__DIR__) . '/backend/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi - Mockup E-Resume</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .wireframe {
            font-family: 'Courier New', Courier, monospace;
            background: #272822;
            color: #f8f8f2;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            white-space: pre;
            line-height: 1.5;
            font-size: 0.9rem;
            page-break-inside: avoid;
        }
        ul, h5 { page-break-inside: avoid; }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>

<?php include dirname(__DIR__) . '/navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-end mb-3 d-print-none">
        <button onclick="exportPDF()" class="btn btn-danger">📄 Export PDF</button>
    </div>
    <div class="panel" id="exportContent">
        <h3 class="section-title">Mockup Antarmuka (Wireframe) E-Resume Medis</h3>
        <p class="text-muted mb-4">Mockup ini merepresentasikan struktur tata letak (layout) sistem yang sudah kita bangun, berfokus pada pengalaman pengguna yang responsif dan terintegrasi.</p>

        <div class="wireframe">+-----------------------------------------------------------------------------+
| [LOGO ESA UNGGUL]    Sistem E-Resume Medis            [Home] [Registrasi]   |
+-----------------------------------------------------------------------------+
|                                                                             |
|  FORMULIR E-RESUME MEDIS                                                    |
|  -------------------------------------------------------------------------  |
|                                                                             |
|  [PILIH PASIEN DARI REGISTRASI ▼ ]  <-- (Triggers Auto-Populate)            |
|                                                                             |
|  IDENTITAS PASIEN & PERAWATAN                                               |
|  +-----------------------+ +-----------------------+ +--------------------+ |
|  | No RM: 00-00-01 (Auto)| | Nama: Budi Santoso    | | Tgl Lahir: ...     | |
|  +-----------------------+ +-----------------------+ +--------------------+ |
|  +-----------------------+ +-----------------------+ +--------------------+ |
|  | Tgl Masuk: 2026-06-20 | | Tgl Keluar: YYYY-MM-DD| | Lama: 3 Hari       | |
|  +-----------------------+ +-----------------------+ +--------------------+ |
|                                                                             |
|  DOKTER PENANGGUNG JAWAB                                                    |
|  +-------------------------------------------------+ +--------------------+ |
|  | DPJP Utama: [Pilih Dokter dari Master ▼ ]       | |  [ BARCODE TTD ]   | |
|  +-------------------------------------------------+ |                    | |
|  | Rawat Bersama? [ Tidak ▼ ]                      | |  Dr. Fulan, Sp.PD  | |
|  +-------------------------------------------------+ +--------------------+ |
|                                                                             |
|  KLINIS & PEMERIKSAAN FISIK                                                 |
|  +------------------------------------------------------------------------+ |
|  | Diagnosa Masuk: Demam tinggi 3 hari (Otomatis dari Registrasi)         | |
|  +------------------------------------------------------------------------+ |
|  | Tanda Vital:  [TD: 120/80] [N: 80x/m] [S: 36.5] [P: 20x/m] [Sat: 99%]  | |
|  +------------------------------------------------------------------------+ |
|                                                                             |
|  DIAGNOSA AKHIR & PROSEDUR (INTEGRASI ICD)                                  |
|  +------------------------------------------------------------------------+ |
|  | Diagnosa Utama (ICD-10): [ A09 - Diarrhoea and gastroenteritis ... 🔍] | |
|  +------------------------------------------------------------------------+ |
|  | Prosedur / Operasi (ICD-9): [ 99.18 - Injection of antibiotics ... 🔍] | |
|  +------------------------------------------------------------------------+ |
|                                                                             |
|  RENCANA PULANG                                                             |
|  +------------------------------------------------------------------------+ |
|  | Kondisi Pulang: [ Diijinkan Pulang ▼ ]                                 | |
|  +------------------------------------------------------------------------+ |
|                                                                             |
|  [ < KEMBALI ]                                   [ SIMPAN E-RESUME > ]      |
+-----------------------------------------------------------------------------+</div>

        <h5 class="mt-4">Penjelasan Fungsionalitas Mockup:</h5>
        <ul>
            <li><strong>Pilih Pasien (Dropdown)</strong>: Bagian terpenting dari integrasi. Saat dipilih, memicu event AJAX/Javascript untuk mengisi field identitas di bawahnya secara otomatis.</li>
            <li><strong>Kalkulasi Hari Otomatis</strong>: Jika field <em>Tgl Keluar</em> diisi, sistem otomatis membandingkan dengan <em>Tgl Masuk</em> dan menampilkan jumlah "Lama Dirawat".</li>
            <li><strong>Pencarian ICD Terintegrasi</strong>: Menggunakan tombol pencarian yang terhubung dengan API eksternal (NIH Clinical Tables) untuk standarisasi kodifikasi penyakit.</li>
            <li><strong>Validasi Barcode</strong>: Menarik tanda tangan dan informasi dari <em>Master Dokter</em> secara <em>real-time</em>.</li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function exportPDF() {
    let element = document.getElementById('exportContent');
    let opt = {
        margin:       10,
        filename:     'Dokumentasi_Mockup_EResume.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak:    { mode: ['css', 'legacy'] }
    };
    html2pdf().set(opt).from(element).save();
}
</script>
</body>
</html>

<?php require_once dirname(__DIR__) . '/backend/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi - Flowchart Integrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script type="module">
      import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
      mermaid.initialize({ startOnLoad: true, theme: 'default' });
    </script>
</head>
<body>

<?php include dirname(__DIR__) . '/navbar.php'; ?>

<div class="container mt-5">
    <div class="panel">
        <h3 class="section-title">Flowchart Integrasi Data (E-Form ke E-Resume)</h3>
        <p class="text-muted mb-4">Diagram alir berikut mendeskripsikan bagaimana data pasien bergerak dari awal pasien masuk hingga resume medis dicetak.</p>

        <div class="text-center border p-4 bg-light rounded" style="overflow-x: auto;">
            <pre class="mermaid">
graph TD
    A([Mulai: Pasien Datang]) --> B[Petugas Admisi]
    
    B --> C[Buka e-Form Registrasi]
    C --> D[/Input: Nama, Tgl Lahir, Jenis Kelamin, Tgl Masuk, Keluhan/]
    D --> E{Simpan Data?}
    E -- Ya --> F[(Database: tabel_registrasi)]
    
    G[Dokter DPJP / Rekam Medis] --> H[Buka Form E-Resume]
    H --> I[Pilih Data Pasien dari Dropdown Registrasi]
    
    F -.->|Tarik Data Identitas & Diagnosa Masuk| I
    I --> J[Sistem Melakukan Auto-Populate Form]
    
    J --> K[/Input: Diagnosa Utama ICD-10, Prosedur ICD-9, Terapi, dll/]
    K --> L{Lengkap & Simpan?}
    L -- Ya --> M[(Database: tabel_resume_medis)]
    
    M --> N[Generate Tanda Tangan Barcode & Cetak PDF]
    N --> O([Selesai])
            </pre>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

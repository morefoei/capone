<?php require_once dirname(__DIR__) . '/backend/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi - ERD Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script type="module">
      import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
      mermaid.initialize({ startOnLoad: true, theme: 'default' });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>

<?php include dirname(__DIR__) . '/navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-end mb-3 d-print-none">
        <button onclick="exportPDF()" class="btn btn-danger">📄 Export PDF</button>
    </div>
    <div class="panel" id="exportContent">
        <h3 class="section-title">Entity Relationship Diagram (ERD)</h3>
        <p class="text-muted mb-4">Diagram berikut merepresentasikan relasi dan struktur tabel database (tabel_dokter, tabel_registrasi, tabel_resume_medis, dan tabel_resume_icd) pada Sistem E-Resume.</p>

        <div class="text-center border p-4 bg-light rounded mb-5" style="overflow-x: auto;">
            <pre class="mermaid">
erDiagram
    TABEL_REGISTRASI {
        int id PK
        varchar nomor_rm
        varchar nama_pasien
        date tanggal_lahir
        varchar jenis_kelamin
        date tgl_masuk
        varchar penyakit
        timestamp created_at
    }

    TABEL_DOKTER {
        int id PK
        varchar nama_dokter
        varchar nomor_dokter
        enum jenis_dokter
        varchar spesialis
        varchar tanda_tangan
        timestamp created_at
    }

    TABEL_RESUME_MEDIS {
        int id PK
        int registrasi_id FK
        varchar nomor_rm
        varchar nama_pasien
        date tgl_masuk
        date tgl_keluar
        int lama_dirawat
        int dpjp_utama_dokter_id FK
        varchar diagnosa_utama
        varchar icd_utama
        text prosedur_operasi
        int dpjp_pulang_dokter_id FK
    }

    TABEL_RESUME_ICD {
        int id PK
        int resume_id FK
        varchar tipe
        varchar icd_code
        text icd_name
    }

    %% Relasi Tabel
    TABEL_REGISTRASI ||--o{ TABEL_RESUME_MEDIS : "memiliki (1:N)"
    TABEL_DOKTER ||--o{ TABEL_RESUME_MEDIS : "sebagai DPJP (1:N)"
    TABEL_RESUME_MEDIS ||--o{ TABEL_RESUME_ICD : "mencatat detail ICD (1:N)"
            </pre>
            <small class="text-muted mt-2 d-block">*Catatan: Hanya kolom-kolom utama yang ditampilkan pada diagram di atas untuk menyederhanakan visualisasi.</small>
        </div>

        <h4 class="mb-3">Penjelasan Relasi Tabel</h4>
        <ul>
            <li class="mb-2"><strong>tabel_registrasi ke tabel_resume_medis (One-to-Many / 1:N)</strong>:<br>
            Satu data pendaftaran pasien (<code>tabel_registrasi.id</code>) dapat dibuatkan satu atau beberapa dokumen E-Resume (<code>tabel_resume_medis.registrasi_id</code>).</li>
            
            <li class="mb-2"><strong>tabel_dokter ke tabel_resume_medis (One-to-Many / 1:N)</strong>:<br>
            Satu dokter di Master Dokter (<code>tabel_dokter.id</code>) bisa bertindak sebagai DPJP Utama untuk banyak data E-Resume (<code>tabel_resume_medis.dpjp_utama_dokter_id</code>), dan juga sebagai DPJP yang memulangkan pasien.</li>
            
            <li class="mb-2"><strong>tabel_resume_medis ke tabel_resume_icd (One-to-Many / 1:N)</strong>:<br>
            Satu dokumen E-Resume (<code>tabel_resume_medis.id</code>) dapat memiliki banyak kode ICD tambahan (Diagnosa Utama, Sekunder, Prosedur) yang disimpan di tabel relasional (<code>tabel_resume_icd.resume_id</code>).</li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function exportPDF() {
    let element = document.getElementById('exportContent');
    let opt = {
        margin:       10,
        filename:     'Dokumentasi_ERD_Database.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save();
}
</script>
</body>
</html>

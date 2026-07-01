<?php require_once __DIR__ . '/backend/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <div class="hero-section text-center text-md-start d-flex flex-column flex-md-row align-items-center justify-content-between gap-5">
        <div class="flex-grow-1">
            <h1 class="fw-bold mb-3" style="color: var(--text-main); font-size: 2.5rem; letter-spacing: -1px;">
                Sistem E-Resume Medis
            </h1>
            <p class="lead text-muted mb-4 fs-5" style="max-width: 600px;">
                Sistem Informasi Rekam Medis Elektronik Terintegrasi - Capstone RMIK Universitas Esa Unggul. Kelola resume pasien dengan cepat, aman, dan efisien.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4 justify-content-center justify-content-md-start">
                <a class="btn btn-primary btn-lg shadow-sm" href="/form/tambah_resume" role="button">
                    Mulai Isi Form
                </a>
                <a class="btn btn-light btn-lg border shadow-sm" href="/dashboard" role="button" style="color: var(--text-main);">
                    Lihat Dashboard
                </a>
            </div>
        </div>
        <div class="flex-shrink-0 text-center">
            <div class="bg-white p-4 rounded-circle shadow-sm d-inline-block border">
                <img src="/assets/img/logo-ueu-unggul.png" alt="Logo Esa Unggul" class="img-fluid" style="height: 140px; width: 140px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

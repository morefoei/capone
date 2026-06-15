<?php
// Tampilkan error jika ada masalah
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sesuaikan path koneksi Anda. Jika file data.php ada di luar dan koneksi.php ada di dalam folder input:
include 'input/koneksi.php'; 

// Persiapkan variabel default
$label_penyakit = [];
$data_jumlah = [];
$penyakit_terbanyak = "Belum Ada Data";
$jumlah_terbanyak = 0;
$result_tabel = null;

try {
    // ==========================================
    // 1. QUERY GRAFIK (Menggunakan kolom diagnosis_utama)
    // ==========================================
    $query_grafik = "SELECT diagnosis_utama, COUNT(*) as jumlah 
                     FROM resume_medis 
                     WHERE diagnosis_utama IS NOT NULL AND diagnosis_utama != ''
                     GROUP BY diagnosis_utama 
                     ORDER BY jumlah DESC 
                     LIMIT 5";
    
    $result_grafik = mysqli_query($koneksi, $query_grafik);
    if (!$result_grafik) throw new Exception("Gagal query grafik: " . mysqli_error($koneksi));

    $is_first = true;
    while ($row = mysqli_fetch_assoc($result_grafik)) {
        $label_penyakit[] = $row['diagnosis_utama'];
        $data_jumlah[] = $row['jumlah'];
        
        if ($is_first) {
            $penyakit_terbanyak = $row['diagnosis_utama'];
            $jumlah_terbanyak = $row['jumlah'];
            $is_first = false;
        }
    }

    // ==========================================
    // 2. QUERY TABEL (HANYA MEMANGGIL KOLOM YANG ADA DI GAMBAR)
    // ==========================================
    $query_tabel = "SELECT id_resume, no_rm, dpjp, diagnosis_utama, tgl_pulang 
                    FROM resume_medis 
                    ORDER BY id_resume DESC 
                    LIMIT 50";
                    
    $result_tabel = mysqli_query($koneksi, $query_tabel);
    if (!$result_tabel) throw new Exception("Gagal query tabel: " . mysqli_error($koneksi));

} catch (Exception $e) {
    die("<div style='margin:50px; font-family:sans-serif;'><h2 style='color:red;'>Error Database</h2><p>" . $e->getMessage() . "</p></div>");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Laporan Penyakit - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<?php 
// Panggil navbar (sesuaikan path-nya jika perlu, misal: include 'navbar.php';)
if(file_exists('navbar.php')) include 'navbar.php'; 
?>

<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">📊 Dashboard Surveilans Klinis</h3>
        <div>
            <a href="export_excel.php" class="btn btn-success me-2">📊 Export ke Excel (Barcode)</a>
            <button class="btn btn-outline-primary" onclick="window.print()">🖨️ Cetak Laporan</button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-primary text-white h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title text-light mb-0">Total Pasien Terdaftar (Resume)</h5>
                    <h1 class="display-4 fw-bold mt-2">
                        <?php 
                            $q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM resume_medis");
                            $d_total = mysqli_fetch_assoc($q_total);
                            echo $d_total['total'];
                        ?>
                    </h1>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 bg-danger text-white h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title text-light mb-0">Penyakit Terbanyak Saat Ini</h5>
                    <h2 class="fw-bold mt-2 text-center text-uppercase">
                        <?php echo htmlspecialchars($penyakit_terbanyak); ?>
                    </h2>
                    <span class="badge bg-white text-danger fs-6 mt-1">Ditemukan pada <?php echo $jumlah_terbanyak; ?> Pasien</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                    <h5 class="fw-bold text-dark">📈 Top 5 Distribusi Penyakit</h5>
                </div>
                <div class="card-body">
                    <canvas id="grafikPenyakit" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                    <h5 class="fw-bold text-dark">📋 Daftar Resume Kepulangan Pasien</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-dark sticky-top">
                                <tr>
                                    <th>No</th>
                                    <th>No. RM</th>
                                    <th>DPJP</th>
                                    <th>Diagnosis (Penyakit)</th>
                                    <th>Tanggal Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_tabel && mysqli_num_rows($result_tabel) > 0) {
                                    $no = 1;
                                    while ($baris = mysqli_fetch_assoc($result_tabel)) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($baris['no_rm']) . "</td>";
                                        echo "<td>" . htmlspecialchars($baris['dpjp']) . "</td>";
                                        echo "<td><span class='badge bg-info text-dark'>" . htmlspecialchars($baris['diagnosis_utama']) . "</span></td>";
                                        echo "<td>" . date('d/m/Y', strtotime($baris['tgl_pulang'])) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center text-muted py-4'>Belum ada data.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    const labelData = <?php echo json_encode($label_penyakit); ?>;
    const jumlahData = <?php echo json_encode($data_jumlah); ?>;

    const ctx = document.getElementById('grafikPenyakit').getContext('2d');
    
    const myChart = new Chart(ctx, {
        type: 'doughnut', 
        data: {
            labels: labelData,
            datasets: [{
                label: 'Jumlah Kasus',
                data: jumlahData,
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
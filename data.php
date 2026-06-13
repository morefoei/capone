<?php
// Pastikan file koneksi database sudah benar
include 'koneksi.php';

// ==========================================
// 1. QUERY UNTUK GRAFIK & PENYAKIT TERBANYAK
// ==========================================
$query_grafik = "SELECT diagnosis_utama, COUNT(*) as jumlah 
                 FROM resume_medis 
                 WHERE diagnosis_utama IS NOT NULL AND diagnosis_utama != ''
                 GROUP BY diagnosis_utama 
                 ORDER BY jumlah DESC 
                 LIMIT 5"; // Mengambil 5 penyakit terbanyak
$result_grafik = mysqli_query($koneksi, $query_grafik);

$label_penyakit = [];
$data_jumlah = [];
$penyakit_terbanyak = "Belum Ada Data";
$jumlah_terbanyak = 0;

$is_first = true;
while ($row = mysqli_fetch_assoc($result_grafik)) {
    $label_penyakit[] = $row['diagnosis_utama'];
    $data_jumlah[] = $row['jumlah'];
    
    // Menangkap penyakit urutan ke-1 untuk ditampilkan di kartu atas
    if ($is_first) {
        $penyakit_terbanyak = $row['diagnosis_utama'];
        $jumlah_terbanyak = $row['jumlah'];
        $is_first = false;
    }
}

// ==========================================
// 2. QUERY UNTUK TABEL DAFTAR PASIEN
// ==========================================
$query_tabel = "SELECT no_rm, nama_pasien, jenis_kelamin, diagnosis_utama, tgl_pulang 
                FROM resume_medis 
                ORDER BY tgl_pulang DESC 
                LIMIT 50"; // Menampilkan 50 pasien terakhir
$result_tabel = mysqli_query($koneksi, $query_tabel);
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

<?php include 'navbar.php'; ?>

<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">📊 Dashboard Surveilans Klinis</h3>
        <button class="btn btn-outline-primary" onclick="window.print()">🖨️ Cetak Laporan</button>
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
                                    <th>Nama Pasien</th>
                                    <th>L/P</th>
                                    <th>Diagnosis (Penyakit)</th>
                                    <th>Tanggal Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result_tabel) > 0) {
                                    $no = 1;
                                    while ($baris = mysqli_fetch_assoc($result_tabel)) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td class='fw-bold'>" . htmlspecialchars($baris['nama_pasien']) . "<br><small class='text-muted'>RM: " . htmlspecialchars($baris['no_rm']) . "</small></td>";
                                        echo "<td>" . htmlspecialchars($baris['jenis_kelamin']) . "</td>";
                                        echo "<td><span class='badge bg-info text-dark'>" . htmlspecialchars($baris['diagnosis_utama']) . "</span></td>";
                                        echo "<td>" . date('d/m/Y', strtotime($baris['tgl_pulang'])) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center text-muted py-4'>Belum ada data resume medis yang disimpan.</td></tr>";
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
    // Menerima data array PHP dan mengubahnya menjadi format JavaScript (JSON)
    const labelData = <?php echo json_encode($label_penyakit); ?>;
    const jumlahData = <?php echo json_encode($data_jumlah); ?>;

    const ctx = document.getElementById('grafikPenyakit').getContext('2d');
    
    // Konfigurasi Chart
    const myChart = new Chart(ctx, {
        type: 'doughnut', // Bisa diganti 'bar', 'pie', atau 'line'
        data: {
            labels: labelData,
            datasets: [{
                label: 'Jumlah Kasus',
                data: jumlahData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
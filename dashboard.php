<?php
require_once __DIR__ . '/backend/koneksi.php';

// Ambil 10 besar penyakit dari tabel_resume_medis berdasarkan diagnosa_utama
$query = "SELECT diagnosa_utama AS penyakit, COUNT(id) AS jumlah 
          FROM tabel_resume_medis 
          WHERE diagnosa_utama IS NOT NULL AND trim(diagnosa_utama) != '' 
          GROUP BY diagnosa_utama 
          ORDER BY jumlah DESC 
          LIMIT 10";

$result = mysqli_query($koneksi, $query);

$labels = [];
$data_jumlah = [];
$top10 = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Potong nama penyakit jika terlalu panjang untuk grafik
        $penyakit = htmlspecialchars($row['penyakit']);
        $label_short = (strlen($penyakit) > 30) ? substr($penyakit, 0, 30) . '...' : $penyakit;
        
        $labels[] = $label_short;
        $data_jumlah[] = (int)$row['jumlah'];
        $top10[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Laporan 10 Besar Penyakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js untuk Grafik Batang -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SheetJS untuk Export Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- HTML2PDF untuk Export PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .dashboard-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .card-title { color: var(--text-main); font-weight: 700; margin: 0; font-size: 1.15rem; letter-spacing: -0.3px; }
        .badge-rank { font-size: 0.85rem; padding: 6px 12px; border-radius: 6px; font-weight: 700; display: inline-block; min-width: 45px; text-align: center; }
        .rank-1 { background-color: #FEF08A; color: #854D0E; } /* Gold */
        .rank-2 { background-color: #E2E8F0; color: #475569; } /* Silver */
        .rank-3 { background-color: #FFEDD5; color: #9A3412; } /* Bronze */
        .rank-other { background-color: #F1F5F9; color: #64748B; border: 1px solid #E2E8F0; }
        .chart-container { position: relative; height: 400px; width: 100%; padding: 10px; }
        .btn-action { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; padding: 8px 16px; border-radius: 8px; transition: all 0.2s; }
        .btn-action:hover { transform: translateY(-1px); }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container dashboard-container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: var(--text-main); letter-spacing: -0.5px;">Dashboard Laporan</h2>
            <p class="text-muted mb-0">Statistik dan daftar 10 besar diagnosa penyakit terbanyak.</p>
        </div>
        <div class="d-print-none d-flex gap-2 flex-wrap">
            <button onclick="exportAllExcel()" class="btn btn-light border btn-action text-success shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16"><path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/></svg>
                Export Excel
            </button>
            <button onclick="exportAllPDF()" class="btn btn-light border btn-action text-danger shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/><path fill-rule="evenodd" d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.72 11.72 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/></svg>
                Export PDF
            </button>
            <button onclick="window.print()" class="btn btn-primary btn-action shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/><path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/></svg>
                Cetak
            </button>
        </div>
    </div>

    <!-- Tabel 10 Besar Penyakit -->
    <div class="card border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Top 10 Diagnosa Penyakit (Utama)</h5>
            <div class="d-print-none d-flex gap-2">
                <button onclick="exportTableExcel()" class="btn btn-sm btn-light border text-success">Excel</button>
                <button onclick="exportTablePDF()" class="btn btn-sm btn-light border text-danger">PDF</button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tablePenyakit">
                    <thead>
                        <tr>
                            <th class="text-center" width="80">Peringkat</th>
                            <th>Diagnosa Penyakit (ICD-10)</th>
                            <th class="text-center" width="150">Jumlah Kasus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($top10) > 0): ?>
                            <?php foreach ($top10 as $index => $row): ?>
                                <?php 
                                    $rank = $index + 1;
                                    $badgeClass = 'rank-other';
                                    if ($rank === 1) $badgeClass = 'rank-1';
                                    elseif ($rank === 2) $badgeClass = 'rank-2';
                                    elseif ($rank === 3) $badgeClass = 'rank-3';
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="badge-rank <?= $badgeClass ?>">#<?= $rank ?></span>
                                    </td>
                                    <td class="fw-medium text-dark"><?= htmlspecialchars($row['penyakit']) ?></td>
                                    <td class="text-center">
                                        <span class="badge" style="background-color: var(--primary); color: white; padding: 6px 12px; font-size: 0.85rem; border-radius: 20px;"><?= $row['jumlah'] ?> Pasien</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">Belum ada data diagnosa penyakit di database.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grafik Batang -->
    <div class="card border-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Grafik Statistik</h5>
            <div class="d-print-none">
                <button onclick="exportChartPNG()" class="btn btn-sm btn-light border text-primary">Export PNG</button>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Template Hidden untuk Export Excel -->
<div id="excelTemplateWrapper" style="display: none;">
    <table id="excelTemplate" border="1" style="border-collapse: collapse;">
        <tr>
            <td rowspan="3" align="center" valign="middle" style="border: 1px solid black; width: 120px;">
                <!-- Gunakan URL absolute agar gambar tampil di Excel -->
                <img src="<?= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] ?>/assets/img/logo-ueu-unggul.png" width="100" height="100">
            </td>
            <td colspan="2" style="border: 1px solid black; font-size: 16px; font-weight: bold; vertical-align: middle;">LAPORAN 10 BESAR DIAGNOSA PENYAKIT</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; font-size: 14px; font-weight: bold; vertical-align: middle;">Universitas Esa Unggul</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 1px solid black; font-size: 12px; color: #555; vertical-align: middle;">Periode: Seluruh Waktu</td>
        </tr>
        <tr>
            <th style="border: 1px solid black; font-weight: bold; font-size: 14px; text-align: center; vertical-align: middle; padding: 5px;">Peringkat</th>
            <th style="border: 1px solid black; font-weight: bold; font-size: 14px; text-align: center; vertical-align: middle; padding: 5px; width: 300px;">Diagnosa Penyakit (ICD-10)</th>
            <th style="border: 1px solid black; font-weight: bold; font-size: 14px; text-align: center; vertical-align: middle; padding: 5px; width: 150px;">Jumlah Kasus</th>
        </tr>
        <?php if (count($top10) > 0): ?>
            <?php foreach ($top10 as $index => $row): ?>
                <tr>
                    <td align="center" style="border: 1px solid black; text-align: center; vertical-align: middle; padding: 5px;"><?= $index + 1 ?></td>
                    <td style="border: 1px solid black; vertical-align: middle; padding: 5px;"><?= htmlspecialchars($row['penyakit']) ?></td>
                    <td align="center" style="border: 1px solid black; text-align: center; vertical-align: middle; padding: 5px;"><?= $row['jumlah'] ?> Pasien</td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" align="center" style="border: 1px solid black; text-align: center; padding: 5px;">Belum ada data</td></tr>
        <?php endif; ?>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const labels = <?= json_encode($labels) ?>;
    const dataJumlah = <?= json_encode($data_jumlah) ?>;

    if(labels.length > 0) {
        const ctx = document.getElementById('barChart').getContext('2d');
        
        // Buat gradien warna untuk grafik (Indigo modern)
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.9)');
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0.2)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Kasus',
                    data: dataJumlah,
                    backgroundColor: gradient,
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(67, 56, 202, 1)',
                    hoverBorderColor: 'rgba(67, 56, 202, 1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        titleFont: { size: 14, family: "'Plus Jakarta Sans', sans-serif" },
                        bodyFont: { size: 14, family: "'Plus Jakarta Sans', sans-serif" },
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 13, family: "'Plus Jakarta Sans', sans-serif" },
                            color: '#64748B'
                        },
                        grid: {
                            color: '#F1F5F9'
                        },
                        border: { display: false }
                    },
                    x: {
                        ticks: {
                            font: { size: 12, family: "'Plus Jakarta Sans', sans-serif" },
                            color: '#64748B'
                        },
                        grid: {
                            display: false
                        },
                        border: { display: false }
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                }
            }
        });
    } else {
        document.getElementById('barChart').parentElement.innerHTML = '<p class="text-center text-muted mt-5 py-4">Grafik tidak tersedia karena belum ada data penyakit.</p>';
    }
});

// Export Functions
function exportTableExcel() {
    let table = document.getElementById('excelTemplate');
    
    // Konversi tabel HTML ke format Excel (.xls)
    let uri = 'data:application/vnd.ms-excel;base64,';
    let template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
    
    let base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) };
    let format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) };
    
    let ctx = { worksheet: '10 Besar Penyakit', table: table.innerHTML };
    let link = document.createElement('a');
    link.href = uri + base64(format(template, ctx));
    link.download = 'Laporan_10_Besar_Penyakit.xls';
    link.click();
}

function exportTablePDF() {
    let element = document.getElementById('tablePenyakit').closest('.card');
    
    let opt = {
        margin:       10,
        filename:     'Top_10_Diagnosa_Penyakit.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    // Hide buttons inside the card before exporting
    let buttons = element.querySelectorAll('.d-print-none');
    buttons.forEach(b => b.style.display = 'none');
    
    html2pdf().set(opt).from(element).save().then(() => {
        buttons.forEach(b => b.style.display = ''); // restore
    });
}

function exportChartPNG() {
    let canvas = document.getElementById('barChart');
    
    // Buat canvas sementara dengan background putih agar tidak transparan saat di-export
    let newCanvas = document.createElement('canvas');
    newCanvas.width = canvas.width;
    newCanvas.height = canvas.height;
    let ctx = newCanvas.getContext('2d');
    
    // Isi dengan warna putih solid
    ctx.fillStyle = '#FFFFFF';
    ctx.fillRect(0, 0, newCanvas.width, newCanvas.height);
    
    // Gambar grafik dari web ke atas canvas putih ini
    ctx.drawImage(canvas, 0, 0);
    
    let imgURL = newCanvas.toDataURL("image/png");
    let link = document.createElement('a');
    link.download = 'Grafik_10_Besar_Penyakit.png';
    link.href = imgURL;
    link.click();
}

function exportAllExcel() {
    exportTableExcel();
    setTimeout(() => {
        alert("Catatan: Hanya data tabel yang di-export ke Excel. Untuk melihat tabel dan grafik secara bersamaan, silakan gunakan 'Export All PDF'.");
    }, 500);
}

function exportAllPDF() {
    let element = document.querySelector('.dashboard-container');
    
    let opt = {
        margin:       10,
        filename:     'Dashboard_Laporan_Penyakit.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    // Hide all print-none buttons
    let buttons = element.querySelectorAll('.d-print-none');
    buttons.forEach(b => b.style.display = 'none');
    
    html2pdf().set(opt).from(element).save().then(() => {
        // Restore buttons
        buttons.forEach(b => b.style.display = '');
    });
}
</script>

</body>
</html>

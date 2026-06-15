<?php
// error_reporting(0); // Matikan error untuk file Excel
include 'input/koneksi.php';

// Format nama file
$filename = "Export_Data_Resume_" . date('Ymd_His') . ".xls";

// Header untuk memicu download file Excel
header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Data Resume</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 5px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; font-weight: bold; }
    </style>
</head>
<body>

<h3>Laporan Data Resume Medis (E-Resume)</h3>
<p>Diekspor pada: <?php echo date('d-m-Y H:i:s'); ?></p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>No. RM</th>
            <th>Tanggal Pulang</th>
            <th>Diagnosis Utama</th>
            <th>Tindakan / Prosedur</th>
            <th>Nama DPJP</th>
            <th>Tanda Tangan (Barcode)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT no_rm, tgl_pulang, diagnosis_utama, tindakan, dpjp 
                  FROM resume_medis 
                  ORDER BY id_resume DESC";
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $dpjp = $row['dpjp'] ? htmlspecialchars($row['dpjp']) : 'Tidak Ada Data';
                
                // Menghasilkan URL barcode menggunakan API gratis (TEC-IT)
                // Jika dpjp kosong, gunakan string default agar API tidak error
                $barcode_data = urlencode(trim($row['dpjp'] != '' ? $row['dpjp'] : 'KOSONG'));
                $barcode_url = "https://barcode.tec-it.com/barcode.ashx?data=" . $barcode_data . "&code=Code128&dpi=96&dataseparator=";

                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['no_rm']) . "</td>";
                echo "<td>" . date('d/m/Y', strtotime($row['tgl_pulang'])) . "</td>";
                echo "<td>" . htmlspecialchars($row['diagnosis_utama']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tindakan']) . "</td>";
                echo "<td>" . $dpjp . "</td>";
                
                // Menampilkan gambar barcode
                echo "<td style='text-align: center; height: 80px;'>";
                echo "<img src='" . $barcode_url . "' alt='Barcode " . $dpjp . "' height='50'>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align:center;'>Belum ada data resume medis.</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>

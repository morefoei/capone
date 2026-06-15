<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Akses tidak valid.");
}

// Format nama file
$filename = "Ringkasan_Pulang_" . preg_replace('/[^A-Za-z0-9\-]/', '_', $_POST['nama_pasien'] ?? 'Pasien') . "_" . date('Ymd_His') . ".xls";

// Header untuk memicu download file Excel
header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

$dpjp = isset($_POST['dpjp']) ? htmlspecialchars($_POST['dpjp']) : 'Tidak Ada Data';

// Menghasilkan URL barcode menggunakan API gratis (TEC-IT)
$barcode_data = urlencode(trim($_POST['dpjp'] != '' ? $_POST['dpjp'] : 'KOSONG'));
$barcode_url = "https://barcode.tec-it.com/barcode.ashx?data=" . $barcode_data . "&code=Code128&dpi=96&dataseparator=";

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Data Resume</title>
    <style>
        table { border-collapse: collapse; width: 100%; max-width: 800px; font-family: sans-serif; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; width: 35%; }
        .header-title { font-size: 18pt; font-weight: bold; text-align: center; margin-bottom: 20px; }
        .ttd-box { text-align: center; height: 100px; vertical-align: middle; }
    </style>
</head>
<body>

<div class="header-title">RINGKASAN PULANG (DISCHARGE SUMMARY)</div>

<table>
    <tr>
        <th colspan="2" style="text-align: center; background-color: #d9edf7;">I. IDENTITAS PASIEN</th>
    </tr>
    <tr>
        <th>Nomor Rekam Medis</th>
        <td><?= htmlspecialchars($_POST['no_rm'] ?? '') ?></td>
    </tr>
    <tr>
        <th>Nama Pasien</th>
        <td><?= htmlspecialchars($_POST['nama_pasien'] ?? '') ?></td>
    </tr>
    <tr>
        <th>Tanggal Lahir</th>
        <td><?= htmlspecialchars($_POST['tgl_lahir'] ?? '') ?></td>
    </tr>
    <tr>
        <th>Jenis Kelamin</th>
        <td><?= htmlspecialchars($_POST['jenis_kelamin'] ?? '') == 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' ?></td>
    </tr>

    <tr>
        <th colspan="2" style="text-align: center; background-color: #d9edf7;">II. DETAIL PELAYANAN</th>
    </tr>
    <tr>
        <th>Tanggal Masuk</th>
        <td><?= htmlspecialchars($_POST['tgl_masuk'] ?? '') ?></td>
    </tr>
    <tr>
        <th>Tanggal Keluar</th>
        <td><?= htmlspecialchars($_POST['tgl_pulang'] ?? '') ?></td>
    </tr>
    <tr>
        <th>Ruang Rawat Terakhir</th>
        <td><?= htmlspecialchars($_POST['ruang_rawat'] ?? '') ?></td>
    </tr>

    <tr>
        <th colspan="2" style="text-align: center; background-color: #d9edf7;">III. KLINIS & DIAGNOSIS</th>
    </tr>
    <tr>
        <th>Diagnosis Masuk</th>
        <td><?= htmlspecialchars($_POST['diagnosa_masuk'] ?? '') ?></td>
    </tr>
    <tr>
        <th>Diagnosis Utama (ICD-10)</th>
        <td><?= htmlspecialchars($_POST['diagnosis_utama'] ?? '') ?> (Kode: <?= htmlspecialchars($_POST['kode_icd10'] ?? '') ?>)</td>
    </tr>
    <tr>
        <th>Ringkasan Riwayat Penyakit</th>
        <td><?= nl2br(htmlspecialchars($_POST['ringkasan_riwayat'] ?? '')) ?></td>
    </tr>
    <tr>
        <th>Prosedur / Tindakan (ICD-9)</th>
        <td><?= htmlspecialchars($_POST['tindakan'] ?? '') ?> (Kode: <?= htmlspecialchars($_POST['kode_icd9'] ?? '') ?>)</td>
    </tr>
    <tr>
        <th>Kondisi Pulang</th>
        <td><?= htmlspecialchars($_POST['kondisi_pulang'] ?? '') ?></td>
    </tr>
    <tr>
        <th>Terapi Pulang</th>
        <td><?= nl2br(htmlspecialchars($_POST['terapi_pulang'] ?? '')) ?></td>
    </tr>

    <tr>
        <th colspan="2" style="text-align: center; background-color: #d9edf7;">IV. PENGESAHAN DPJP</th>
    </tr>
    <tr>
        <th>Nama DPJP Utama</th>
        <td><?= $dpjp ?></td>
    </tr>
    <tr>
        <th>Tanda Tangan (Barcode)</th>
        <td class="ttd-box">
            <img src="<?= $barcode_url ?>" alt="Barcode <?= $dpjp ?>" height="60">
        </td>
    </tr>
</table>

</body>
</html>

<?php
// 1. MENYALAKAN PESAN ERROR (Hapus/comment baris ini jika web sudah siap rilis/live)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. PERBAIKAN PATH AUTOLOAD
// Karena file ini ada di dalam folder /form/, kita harus mundur satu folder menggunakan '../'
// Pastikan folder 'vendor' benar-benar ada di posisi ini.
$autoload_path = '../vendor/autoload.php';
if (!file_exists($autoload_path)) {
    die("<b>Error:</b> Folder vendor tidak ditemukan di path: $autoload_path. Pastikan sudah menjalankan composer install dan letak foldernya benar.");
}
require $autoload_path;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// 3. Tangkap Data dari Form
$no_rm = $_POST['no_rm'] ?? '';
$nama_pasien = $_POST['nama_pasien'] ?? '';
$dpjp = $_POST['dpjp'] ?? 'Tidak Ada DPJP';
$diagnosis_utama = $_POST['diagnosis_utama'] ?? '';

// 4. Generate QR Code Menggunakan cURL (Lebih aman dari file_get_contents)
$qr_data = "Dokumen ini sah dan ditandatangani secara elektronik oleh DPJP: " . $dpjp;
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qr_data);

$ch = curl_init($qr_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$qr_image = curl_exec($ch);
if (curl_errno($ch)) {
    die("<b>Error cURL:</b> Gagal mendownload QR Code. Pesan: " . curl_error($ch));
}
curl_close($ch);

$temp_img = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
if (file_put_contents($temp_img, $qr_image) === false) {
    die("<b>Error Direktori:</b> Gagal menyimpan gambar QR ke temporary folder.");
}

// 5. Buat File Excel Baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Desain Layout Excel
$sheet->setCellValue('A1', 'RESUME MEDIS PASIEN');
$sheet->mergeCells('A1:D1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

$sheet->setCellValue('A3', 'Nomor RM');
$sheet->setCellValue('B3', ': ' . $no_rm);
$sheet->setCellValue('A4', 'Nama Pasien');
$sheet->setCellValue('B4', ': ' . $nama_pasien);
$sheet->setCellValue('A5', 'Diagnosa Utama');
$sheet->setCellValue('B5', ': ' . $diagnosis_utama);

// Area Tanda Tangan & Insert Barcode
$sheet->setCellValue('D8', 'Dokter Penanggung Jawab');

// Memasukkan gambar QR Code ke dalam Excel
try {
    $drawing = new Drawing();
    $drawing->setName('Tanda Tangan QR');
    $drawing->setDescription('QR Code validasi DPJP');
    $drawing->setPath($temp_img); 
    $drawing->setCoordinates('D9'); 
    $drawing->setHeight(90); 
    $drawing->setWorksheet($sheet);
} catch (Exception $e) {
    die("<b>Error Gambar (PhpSpreadsheet):</b> Pastikan ekstensi ext-gd / GD Library aktif di PHP kamu. Pesan: " . $e->getMessage());
}

// Nama DPJP di bawah barcode
$sheet->setCellValue('D14', '( ' . $dpjp . ' )');

$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(30);

// Bersihkan output buffer sebelum kirim file (mencegah error file corrupt)
if (ob_get_length()) { ob_end_clean(); }

// 6. Output file Excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="E-Resume_' . str_replace(' ', '_', $nama_pasien) . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

unlink($temp_img);
exit;
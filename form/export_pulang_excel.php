<?php
// Wajib: Memanggil library PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// 1. Tangkap Data dari Form
$no_rm = $_POST['no_rm'] ?? '';
$nama_pasien = $_POST['nama_pasien'] ?? '';
$dpjp = $_POST['dpjp'] ?? 'Tidak Ada DPJP';
$diagnosis_utama = $_POST['diagnosis_utama'] ?? '';

// 2. Generate QR Code untuk Tanda Tangan DPJP
// Teks yang akan disimpan di dalam Barcode/QR
$qr_data = "Dokumen ini sah dan ditandatangani secara elektronik oleh DPJP: " . $dpjp;

// Kita pakai API gratis untuk generate QR Code
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qr_data);

// Download gambar QR sementara ke server
$qr_image = file_get_contents($qr_url);
$temp_img = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
file_put_contents($temp_img, $qr_image);

// 3. Buat File Excel Baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Desain Layout Excel Sederhana
$sheet->setCellValue('A1', 'RESUME MEDIS PASIEN');
$sheet->mergeCells('A1:D1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

$sheet->setCellValue('A3', 'Nomor RM');
$sheet->setCellValue('B3', ': ' . $no_rm);
$sheet->setCellValue('A4', 'Nama Pasien');
$sheet->setCellValue('B4', ': ' . $nama_pasien);
$sheet->setCellValue('A5', 'Diagnosa Utama');
$sheet->setCellValue('B5', ': ' . $diagnosis_utama);

// 4. Area Tanda Tangan & Insert Barcode
$sheet->setCellValue('D8', 'Dokter Penanggung Jawab');

// Memasukkan gambar QR Code ke dalam Excel
$drawing = new Drawing();
$drawing->setName('Tanda Tangan QR');
$drawing->setDescription('QR Code validasi DPJP');
$drawing->setPath($temp_img); // Ambil gambar yang di-download tadi
$drawing->setCoordinates('D9'); // Letakkan di sel D9
$drawing->setHeight(90); // Ukuran tinggi barcode
$drawing->setWorksheet($sheet);

// Nama DPJP di bawah barcode
$sheet->setCellValue('D14', '( ' . $dpjp . ' )');

// Rapikan Lebar Kolom
$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(30);

// 5. Output file sebagai Excel (.xlsx) dan paksa browser untuk download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="E-Resume_' . str_replace(' ', '_', $nama_pasien) . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

// Hapus file gambar temporary agar server tidak penuh
unlink($temp_img);
exit;
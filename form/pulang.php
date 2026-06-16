<?php
// 1. Panggil koneksi database di paling atas
require_once '../input/koneksi.php'; 

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Pulang (E-Resume) - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Sedikit penyesuaian agar Select2 tingginya sama dengan input Bootstrap */
        .select2-container .select2-selection--single {
            height: 38px !important;
            border: 1px solid #dee2e6 !important;
            border-radius: 0.375rem !important;
            padding: 4px 0px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }
    </style>
</head>
<body class="bg-light">

<?php if (file_exists('navbar.php')) include 'navbar.php'; ?>

<div class="container mt-5 mb-5">

<?php if ($action == 'list'): ?>
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Daftar Pasien - Ringkasan Pulang</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
                <a href="index.php" class="btn btn-warning fw-bold">⬅️ Kembali ke Halaman Utama</a>
            </div>
            
            <div class="row mb-3 d-flex justify-content-between">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari Nama Pasien atau No. RM...">
                </div>
                <div class="col-md-auto">
                    <a href="?action=buat" class="btn btn-success fw-bold">➕ Buat Baru Manual</a>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle" id="patientTable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>11-22-33</td>
                            <td>Budi Santoso</td>
                            <td>1990-05-15</td>
                            <td>L</td>
                            <td>
                                <a href="?action=buat&no_rm=11-22-33&nama_pasien=Budi+Santoso&tgl_lahir=1990-05-15&jk=L" class="btn btn-sm btn-primary">Buat E-Resume</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>44-55-66</td>
                            <td>Siti Aminah</td>
                            <td>1985-08-20</td>
                            <td>P</td>
                            <td>
                                <a href="?action=buat&no_rm=44-55-66&nama_pasien=Siti+Aminah&tgl_lahir=1985-08-20&jk=P" class="btn btn-sm btn-primary">Buat E-Resume</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>77-88-99</td>
                            <td>Joko Widodo</td>
                            <td>1961-06-21</td>
                            <td>L</td>
                            <td>
                                <a href="?action=buat&no_rm=77-88-99&nama_pasien=Joko+Widodo&tgl_lahir=1961-06-21&jk=L" class="btn btn-sm btn-primary">Buat E-Resume</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-muted small mt-2">*Tabel di atas adalah contoh tampilan daftar pasien. Silakan gunakan pencarian atau "Buat Baru Manual" jika pasien belum ada.</div>
        </div>
    </div>

<?php else: ?>
    <?php
    $get_rm = isset($_GET['no_rm']) ? htmlspecialchars($_GET['no_rm']) : '';
    $get_nama = isset($_GET['nama_pasien']) ? htmlspecialchars($_GET['nama_pasien']) : '';
    $get_tgl = isset($_GET['tgl_lahir']) ? htmlspecialchars($_GET['tgl_lahir']) : '';
    $get_jk = isset($_GET['jk']) ? htmlspecialchars($_GET['jk']) : '';
    ?>
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-start w-100 mb-3">
                <a href="?action=list" class="btn btn-warning fw-bold">
                    ⬅️ Kembali ke Daftar
                </a>
            </div>     
            <h4 class="mb-0">Ringkasan Pulang (Discharge Summary / E-Resume)</h4>
            <span class="badge bg-white text-primary fw-bold">No. Form: RI 02/2020/1</span>
        </div>
        <div class="card-body">
            <form id="formRingkasanPulang" action="export_pulang_excel.php" method="POST">
                
                <h5 class="border-bottom pb-2 text-primary">1. Identitas Pasien</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nomor Rekam Medis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" placeholder="00-00-00" value="<?=$get_rm?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nama Lengkap Pasien <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_pasien" value="<?=$get_nama?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_lahir" value="<?=$get_tgl?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option value="" disabled <?=$get_jk==''?'selected':''?>>Pilih...</option>
                            <option value="L" <?=$get_jk=='L'?'selected':''?>>Laki-laki (L)</option>
                            <option value="P" <?=$get_jk=='P'?'selected':''?>>Perempuan (P)</option>
                        </select>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary">2. Detail Pelayanan & Ruang Rawat</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tglMasuk" name="tgl_masuk" onchange="hitungLamaDirawat()" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Keluar/Pulang <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tglPulang" name="tgl_pulang" onchange="hitungLamaDirawat()" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Lama Dirawat</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="lamaDirawat" name="lama_dirawat" readonly placeholder="0">
                            <span class="input-group-text">Hari</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ruang Rawat Terakhir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="ruang_rawat" placeholder="Misal: Ruang Melati Kamar 302" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">DPJP Utama <span class="text-danger">*</span></label>
                        <select class="form-select select2-dpjp" name="dpjp" required>
                            <option value="" disabled selected>Pilih Dokter DPJP...</option>
                            <?php
                            // Mengambil data dokter dari database
                            $query_dokter = mysqli_query($koneksi, "SELECT * FROM dokter ORDER BY nama_dokter ASC");
                            if ($query_dokter && mysqli_num_rows($query_dokter) > 0) {
                                while ($dok = mysqli_fetch_assoc($query_dokter)) {
                                    echo "<option value='{$dok['nama_dokter']}'>{$dok['nama_dokter']} ({$dok['jenis_dokter']})</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Belum ada data dokter. Silakan input di menu DPJP.</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Rawat Bersama (Konsul Dokter Lain)</label>
                        <input type="text" class="form-control" name="rawat_bersama" placeholder="Nama Dokter Konsulen (Tulis 'Tidak Ada' jika tidak ada)">
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary">3. Ringkasan Riwayat Klinis & Pemeriksaan Fisik</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Diagnosa Masuk RS <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="diagnosa_masuk" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Ringkasan Riwayat Penyakit (Anamnesis Singkat) <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="ringkasan_riwayat" rows="3" required></textarea>
                </div>

                <p class="fw-bold mb-1">Pemeriksaan Fisik Akhir (Tanda-Tanda Vital):</p>
                <div class="row mb-3 g-2">
                    <div class="col-md-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text fw-bold">TD</span>
                            <input type="text" class="form-control" name="td" placeholder="120/80" required>
                            <span class="input-group-text">mmHg</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text fw-bold">N</span>
                            <input type="text" class="form-control" name="nadi" placeholder="80" required>
                            <span class="input-group-text">x/m</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text fw-bold">S</span>
                            <input type="text" class="form-control" name="suhu" placeholder="36.5" required>
                            <span class="input-group-text">°C</span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text fw-bold">P</span>
                            <input type="text" class="form-control" name="pernapasan" placeholder="20" required>
                            <span class="input-group-text">x/m</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text fw-bold">Sat O2</span>
                            <input type="text" class="form-control" name="sat_o2" placeholder="98" required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary">4. Hasil Pemeriksaan Penunjang Penting (Kritis)</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Laboratorium (Hasil Abnormal/Penting)</label>
                        <textarea class="form-control" name="penunjang_lab" rows="2" placeholder="Contoh: Hb 10.2 g/dL, Leukosit 12.000 /µL..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Penunjang Lain (Radiologi, EKG, USG, dll)</label>
                        <textarea class="form-control" name="penunjang_lain" rows="2" placeholder="Contoh: Thorax X-Ray: Cardiomegaly ringan, USG Abdomen: Cholelithiasis..."></textarea>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary">5. Diagnosis, Prosedur & Kodifikasi (ICD-10 & ICD-9-CM)</h5>
                <div class="row mb-3">
                    <div class="col-md-9">
                        <label class="form-label fw-bold">Diagnosis Utama (Main Diagnosis) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="diagnosis_utama" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Kode ICD-10 Utama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kode_icd10" placeholder="Misal: N20.0" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9">
                        <label class="form-label">Diagnosis Sekunder / Komorbiditas (Bila Ada)</label>
                        <input type="text" class="form-control mb-2" name="diag_sekunder_1" placeholder="Diagnosis sekunder 1">
                        <input type="text" class="form-control" name="diag_sekunder_2" placeholder="Diagnosis sekunder 2">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kode ICD-10 Sekunder</label>
                        <input type="text" class="form-control mb-2" name="icd10_sekunder_1" placeholder="Misal: E11.9">
                        <input type="text" class="form-control" name="icd10_sekunder_2" placeholder="Misal: I10">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-9">
                        <label class="form-label fw-bold">Prosedur / Operasi / Tindakan Medis</label>
                        <input type="text" class="form-control" name="tindakan" placeholder="Misal: Pemasangan Kateter, Appendectomy, USG">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Kode ICD-9-CM</label>
                        <input type="text" class="form-control" name="kode_icd9" placeholder="Misal: 59.8 atau 47.09">
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary">6. Keluar Perawatan & Terapi Pulang</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Pengobatan Selama Dirawat (Terapi Intravena/Kritis)</label>
                    <textarea class="form-control" name="terapi_selama_dirawat" rows="2" placeholder="Contoh: Ceftriaxone 1gr/12j IV, Infus RL 20 tpm..."></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kondisi Saat Pulang <span class="text-danger">*</span></label>
                        <select class="form-select" name="kondisi_pulang" required>
                            <option value="" disabled selected>Pilih kondisi pulang...</option>
                            <option value="Diizinkan Pulang">Diizinkan Pulang (Sembuh/Membaik)</option>
                            <option value="Dirujuk">Dirujuk ke RS Lain Layanan Lanjutan</option>
                            <option value="Atas Permintaan Sendiri">Pulang Atas Permintaan Sendiri (APS)</option>
                            <option value="Meninggal">Meninggal Dunia</option>
                            <option value="Melarikan Diri">Melarikan Diri / Keluar Tanpa Izin</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Terapi Pulang (Obat Jalan) & Instruksi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="terapi_pulang" rows="2" placeholder="Nama obat oral, dosis, aturan pakai, dan jadwal kontrol ulangan" required></textarea>
                    </div>
                </div>

                <div class="form-check mb-4 mt-4">
                    <input class="form-check-input" type="checkbox" id="autentikasi" name="autentikasi" value="1" required>
                    <label class="form-check-label text-success fw-bold" for="autentikasi">
                        Saya Dokter DPJP Utama menyatakan data ringkasan pulang ini valid, lengkap, dan siap di-generate sebagai Dokumen Kelengkapan Akreditasi. *
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold shadow">💾 Simpan E-Resume & Buka Lembar Cetak</button>
                    <button type="submit" formaction="export_pulang_excel.php" class="btn btn-success w-100 btn-lg fw-bold shadow">📊 Export ke Excel (Barcode TTD)</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// --- Inisiasi Select2 untuk Dropdown DPJP ---
$(document).ready(function() {
    $('.select2-dpjp').select2({
        placeholder: "Ketik nama dokter untuk mencari...",
        allowClear: true,
        width: '100%' // Menyesuaikan dengan grid Bootstrap
    });
});

// --- Fitur Search Sederhana Untuk Tabel Pasien ---
if (document.getElementById('searchInput')) {
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#patientTable tbody tr');
        
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            if(text.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// --- Fungsi Menghitung Lama Dirawat ---
function hitungLamaDirawat() {
    var tglMasukStr = document.getElementById('tglMasuk').value;
    var tglPulangStr = document.getElementById('tglPulang').value;
    
    if (tglMasukStr && tglPulangStr) {
        var tglMasuk = new Date(tglMasukStr);
        var tglPulang = new Date(tglPulangStr);
        
        // Menghitung selisih milidetik
        var selisihWaktu = tglPulang.getTime() - tglMasuk.getTime();
        
        // Mengubah milidetik ke hari
        var selisihHari = Math.ceil(selisihWaktu / (1000 * 3600 * 24));
        
        if (selisihHari >= 0) {
            // Jika masuk dan keluar di hari yang sama dihitung 1 hari
            if (selisihHari == 0) selisihHari = 1; 
            document.getElementById('lamaDirawat').value = selisihHari;
        } else {
            document.getElementById('lamaDirawat').value = 0;
        }
    }
}
</script>

</body>
</html>
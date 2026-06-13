<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Resume Medis - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">RESUME MEDIS</h4>
            <span class="badge bg-light text-primary fs-6">RI 02/2020/1</span>
        </div>
        <div class="card-body p-4">
            <form id="formResumeMedis" action="simpan_resume.php" method="POST">
                
                <h5 class="border-bottom pb-2 text-primary fw-bold">Identitas Pasien</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Nomor RM</label>
                        <input type="text" class="form-control" name="no_rm" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Nama Pasien</label>
                        <input type="text" class="form-control" name="nama_pasien" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Jenis Kelamin</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jk" value="L" required>
                                <label class="form-check-label">L</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jk" value="P" required>
                                <label class="form-check-label">P</label>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary fw-bold">Detail Pelayanan</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tglMasuk" name="tgl_masuk" onchange="hitungHari()" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Tanggal Keluar</label>
                        <input type="date" class="form-control" id="tglKeluar" name="tgl_keluar" onchange="hitungHari()" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold">Lama Dirawat</label>
                        <div class="input-group">
                            <input type="number" class="form-control bg-light" id="lamaDirawat" name="lama_dirawat" readonly>
                            <span class="input-group-text">Hari</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ruang Rawat</label>
                        <input type="text" class="form-control" name="ruang_rawat" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">DPJP Utama</label>
                        <input type="text" class="form-control" name="dpjp_utama" required>
                    </div>
                    <div class="col-md-6 border rounded p-2 bg-light">
                        <label class="form-label fw-bold mb-1">Rawat Bersama:</label>
                        <div class="mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rawat_bersama" value="Ya" onchange="toggleRawatBersama(true)">
                                <label class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rawat_bersama" value="Tidak" onchange="toggleRawatBersama(false)" checked>
                                <label class="form-check-label">Tidak</label>
                            </div>
                        </div>
                        <div id="divDokterBersama" style="display: none;">
                            <input type="text" class="form-control form-control-sm mb-1" name="dokter_bersama_1" placeholder="1. Nama Dokter Bersama">
                            <input type="text" class="form-control form-control-sm mb-1" name="dokter_bersama_2" placeholder="2. Nama Dokter Bersama">
                            <input type="text" class="form-control form-control-sm" name="dokter_bersama_3" placeholder="3. Nama Dokter Bersama">
                        </div>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary fw-bold">Riwayat & Pemeriksaan</h5>
                <div class="mb-3">
                    <label class="form-label fw-bold">Diagnosa Masuk</label>
                    <input type="text" class="form-control" name="diagnosa_masuk" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Ringkasan Riwayat Penyakit</label>
                    <textarea class="form-control" name="ringkasan_riwayat" rows="3" required></textarea>
                </div>

                <label class="form-label fw-bold">Pemeriksaan Fisik</label>
                <div class="row mb-3 g-2">
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text fw-bold">TD</span>
                            <input type="text" class="form-control" name="td">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text fw-bold">N</span>
                            <input type="text" class="form-control" name="nadi">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text fw-bold">S</span>
                            <input type="text" class="form-control" name="suhu">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text fw-bold">P</span>
                            <input type="text" class="form-control" name="pernapasan">
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <span class="input-group-text fw-bold">Sat O2</span>
                            <input type="text" class="form-control" name="sat_o2">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Laboratorium</label>
                        <textarea class="form-control" name="laboratorium" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Penunjang Lain</label>
                        <textarea class="form-control" name="penunjang_lain" rows="2"></textarea>
                    </div>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary fw-bold">Diagnosa & Prosedur (ICD)</h5>
                
                <div class="row mb-2">
                    <div class="col-md-9">
                        <label class="form-label fw-bold">Diagnosa Utama</label>
                        <input type="text" class="form-control border-primary" name="diag_utama" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Kode ICD</label>
                        <input type="text" class="form-control border-primary" name="icd_utama" required>
                    </div>
                </div>

                <label class="form-label fw-bold mt-2">Diagnosa Sekunder</label>
                <div class="row mb-1"><div class="col-md-9"><input type="text" class="form-control form-control-sm" name="diag_sekunder_1"></div><div class="col-md-3"><input type="text" class="form-control form-control-sm" name="icd_sekunder_1" placeholder="Kode ICD"></div></div>
                <div class="row mb-1"><div class="col-md-9"><input type="text" class="form-control form-control-sm" name="diag_sekunder_2"></div><div class="col-md-3"><input type="text" class="form-control form-control-sm" name="icd_sekunder_2" placeholder="Kode ICD"></div></div>
                <div class="row mb-1"><div class="col-md-9"><input type="text" class="form-control form-control-sm" name="diag_sekunder_3"></div><div class="col-md-3"><input type="text" class="form-control form-control-sm" name="icd_sekunder_3" placeholder="Kode ICD"></div></div>
                <div class="row mb-3"><div class="col-md-9"><input type="text" class="form-control form-control-sm" name="diag_sekunder_4"></div><div class="col-md-3"><input type="text" class="form-control form-control-sm" name="icd_sekunder_4" placeholder="Kode ICD"></div></div>

                <label class="form-label fw-bold">Prosedur/Operasi</label>
                <div class="row mb-1"><div class="col-md-9"><input type="text" class="form-control form-control-sm" name="prosedur_1"></div><div class="col-md-3"><input type="text" class="form-control form-control-sm" name="icd_prosedur_1" placeholder="Kode ICD"></div></div>
                <div class="row mb-3"><div class="col-md-9"><input type="text" class="form-control form-control-sm" name="prosedur_2"></div><div class="col-md-3"><input type="text" class="form-control form-control-sm" name="icd_prosedur_2" placeholder="Kode ICD"></div></div>

                <h5 class="border-bottom pb-2 mt-4 text-primary fw-bold">Tindak Lanjut & Kepulangan</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Pengobatan Selama Dirawat</label>
                    <textarea class="form-control" name="pengobatan_dirawat" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kondisi Pulang</label>
                    <div class="p-2 border rounded">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kondisi_pulang" value="Diijinkan Pulang" required>
                            <label class="form-check-label">Diijinkan Pulang</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kondisi_pulang" value="Dirujuk">
                            <label class="form-check-label">Dirujuk</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kondisi_pulang" value="Atas Permintaan Sendiri">
                            <label class="form-check-label">Atas Permintaan Sendiri</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kondisi_pulang" value="Meninggal">
                            <label class="form-check-label text-danger fw-bold">Meninggal</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="kondisi_pulang" value="Melarikan Diri">
                            <label class="form-check-label">Melarikan Diri</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Instruksi Pulang</label>
                    <textarea class="form-control" name="instruksi_pulang" rows="3" required></textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 offset-md-6 text-end">
                        <label class="form-label fw-bold mb-1">Nama DPJP (Tanda Tangan Elektronik)</label>
                        <input type="text" class="form-control text-center" name="nama_dpjp_ttd" placeholder="(Nama Lengkap DPJP)" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold shadow">
                    <i class="fas fa-save me-2"></i>Simpan Formulir Resume Medis
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // 1. Fungsi Hitung Otomatis Lama Dirawat
    function hitungHari() {
        let masuk = document.getElementById('tglMasuk').value;
        let keluar = document.getElementById('tglKeluar').value;
        
        if (masuk && keluar) {
            let tMasuk = new Date(masuk);
            let tKeluar = new Date(keluar);
            let selisih = tKeluar.getTime() - tMasuk.getTime();
            let hari = Math.ceil(selisih / (1000 * 3600 * 24));
            
            // Jika masuk dan keluar di hari yang sama, dihitung 1 hari
            if (hari === 0) hari = 1;
            
            document.getElementById('lamaDirawat').value = hari >= 0 ? hari : 0;
        }
    }

    // 2. Fungsi Buka-Tutup Kolom "Rawat Bersama"
    function toggleRawatBersama(isYa) {
        let divDokter = document.getElementById('divDokterBersama');
        if(isYa) {
            divDokter.style.display = 'block';
        } else {
            divDokter.style.display = 'none';
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
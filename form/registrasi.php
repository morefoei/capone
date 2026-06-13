<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien Baru - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-start w-100 mb-3">
                <a href="javascript:history.back()" class="btn btn-warning">
                    Kembali
                </a>
            </div>    
            <h4 class="mb-0">Formulir Registrasi Pasien (Admisi)</h4>
        </div>
        <div class="card-body">
            <form id="formRegistrasi" action="simpan_registrasi.php" method="POST">
                
                <h5 class="border-bottom pb-2 text-primary">A. Identitas Sosial (Demografi)</h5>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor Rekam Medis (Auto/Manual) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_rm" placeholder="Misal: 00-12-34-56" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nik" minlength="16" maxlength="16" placeholder="16 Digit KTP" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nama Lengkap Pasien <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_pasien" placeholder="Sesuai KTP" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="tempat_lahir" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="tgl_lahir" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" name="jenis_kelamin" required>
                            <option value="" disabled selected>Pilih...</option>
                            <option value="Laki-laki">Laki-laki (L)</option>
                            <option value="Perempuan">Perempuan (P)</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Agama <span class="text-danger">*</span></label>
                        <select class="form-select" name="agama" required>
                            <option value="" disabled selected>Pilih Agama...</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen Protestan">Kristen Protestan</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Golongan Darah</label>
                        <select class="form-select" name="gol_darah">
                            <option value="Belum Tahu">Belum Tahu</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="no_hp" placeholder="Contoh: 08123456789" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Alamat Tempat Tinggal <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="alamat" rows="2" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota..." required></textarea>
                </div>

                <h5 class="border-bottom pb-2 mt-4 text-primary">B. Penanggung Jawab & Pelayanan</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Penanggung Jawab (Kontak Darurat) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama_pj" placeholder="Nama Suami/Istri/Orang Tua/Keluarga" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hubungan dengan Pasien <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="hubungan_pj" placeholder="Contoh: Anak Kandung, Suami" required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Cara Bayar / Penjamin <span class="text-danger">*</span></label>
                        <select class="form-select" name="cara_bayar" required>
                            <option value="" disabled selected>Pilih metode pembayaran...</option>
                            <option value="Umum / Pribadi">Umum / Pribadi</option>
                            <option value="BPJS Kesehatan">BPJS Kesehatan</option>
                            <option value="BPJS Ketenagakerjaan">BPJS Ketenagakerjaan</option>
                            <option value="Asuransi Swasta">Asuransi Swasta / Perusahaan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tujuan Poliklinik / Unit Layanan <span class="text-danger">*</span></label>
                        <select class="form-select" name="tujuan_poli" required>
                            <option value="" disabled selected>Pilih tujuan layanan...</option>
                            <option value="IGD">Instalasi Gawat Darurat (IGD)</option>
                            <option value="Poli Penyakit Dalam">Poli Penyakit Dalam</option>
                            <option value="Poli Bedah">Poli Bedah</option>
                            <option value="Poli Anak">Poli Anak</option>
                            <option value="Poli Kandungan (Obgyn)">Poli Kandungan (Obgyn)</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">Daftarkan Pasien</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
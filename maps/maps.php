<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Persebaran - Capstone RMIK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            border-radius: 8px;
            z-index: 1;
        }
        /* Animasi loading sederhana saat mencari data */
        #loadingSearch {
            display: none;
        }
    </style>
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Peta Fasilitas Kesehatan & Pemetaan Kasus</h4>
        </div>
        <div class="card-body">
            <p class="text-muted">Gunakan kolom pencarian di bawah untuk mencari Kabupaten/Kecamatan/Kelurahan. Hasil pencarian akan muncul di tabel bawah peta.</p>
            
            <div class="row g-2 mb-4 p-3 bg-white rounded border shadow-sm">
                <div class="col-md-10">
                    <input type="text" class="form-control form-control-lg border-success" id="inputPencarian" placeholder="Cari daerah... (Misal: Kecamatan Palmerah Jakarta)">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success w-100 btn-lg fw-bold" onclick="cariDaerah()">🔍 Cari Lokasi</button>
                </div>
            </div>
            
            <div class="row g-3 mb-4 p-3 bg-light rounded border">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Latitude (Garis Lintang)</label>
                    <input type="text" class="form-control" id="inputLat" value="-6.187311">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Longitude (Garis Bujur)</label>
                    <input type="text" class="form-control" id="inputLng" value="106.773329">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 fw-bold" onclick="updatePetaDariInput()">📍 Update Manual</button>
                </div>
            </div>
            
            <div id="map" class="border shadow-sm mb-4"></div>

            <h5 class="fw-bold border-bottom pb-2 text-success">Daftar Hasil Pencarian Lokasi</h5>
            <div class="text-center text-primary fw-bold" id="loadingSearch">Sedang mencari data ke server OpenStreetMap... ⏳</div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-success">
                        <tr>
                            <th width="5%">No</th>
                            <th width="50%">Nama Lokasi (Kelurahan/Kecamatan/Kabupaten)</th>
                            <th width="15%">Latitude</th>
                            <th width="15%">Longitude</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabelHasilCari">
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pencarian. Ketik nama daerah di atas lalu klik "Cari Lokasi".</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // --- 1. INISIALISASI PETA DASAR ---
    var awalLat = -6.187311;
    var awalLng = 106.773329;
    var map = L.map('map').setView([awalLat, awalLng], 15);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([awalLat, awalLng], { draggable: true }).addTo(map);
    marker.bindPopup("<b>Posisi Terpilih</b><br>Geser pin atau klik peta.").openPopup();

    // --- 2. LOGIKA UPDATE MANUAL & DRAG/KLIK ---
    function updatePetaDariInput() {
        var lat = parseFloat(document.getElementById('inputLat').value);
        var lng = parseFloat(document.getElementById('inputLng').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]); 
            map.setView([lat, lng], 16);  
            marker.getPopup().setContent("<b>Lokasi Input Manual:</b><br>" + lat + ", " + lng).openPopup();
        } else {
            alert("Harap masukkan format angka koordinat yang valid!");
        }
    }

    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        document.getElementById('inputLat').value = lat.toFixed(6);
        document.getElementById('inputLng').value = lng.toFixed(6);
        marker.setLatLng([lat, lng]);
        marker.getPopup().setContent("<b>Lokasi Terpilih (Klik):</b><br>" + lat.toFixed(6) + ", " + lng.toFixed(6)).openPopup();
    });

    marker.on('dragend', function(e) {
        var posisiBaru = marker.getLatLng();
        document.getElementById('inputLat').value = posisiBaru.lat.toFixed(6);
        document.getElementById('inputLng').value = posisiBaru.lng.toFixed(6);
        marker.getPopup().setContent("<b>Lokasi Terpilih (Geser):</b><br>" + posisiBaru.lat.toFixed(6) + ", " + posisiBaru.lng.toFixed(6)).openPopup();
    });

    // =========================================================
    // --- 3. FITUR BARU: API PENCARIAN NOMINATIM OPENSTREETMAP ---
    // =========================================================
    async function cariDaerah() {
        var query = document.getElementById('inputPencarian').value;
        var tabelBody = document.getElementById('tabelHasilCari');
        var loading = document.getElementById('loadingSearch');

        if (query.trim() === "") {
            alert("Ketikkan nama daerah terlebih dahulu!");
            return;
        }

        // Tampilkan loading, bersihkan tabel
        loading.style.display = "block";
        tabelBody.innerHTML = "";

        try {
            // Memanggil API gratis dari OpenStreetMap (Format JSON)
            // countrycodes=id memastikan pencarian hanya berfokus di Indonesia
            var response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id`);
            var data = await response.json();

            loading.style.display = "none";

            if (data.length === 0) {
                tabelBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger fw-bold">Lokasi tidak ditemukan. Coba gunakan kata kunci yang lebih spesifik (Contoh: "Kecamatan Grogol Petamburan").</td></tr>`;
                return;
            }

            // Looping data dari API dan buatkan baris tabel (maksimal 10 hasil agar tidak penuh)
            var maksimalHasil = Math.min(data.length, 10);
            
            for (var i = 0; i < maksimalHasil; i++) {
                var item = data[i];
                var latFormat = parseFloat(item.lat).toFixed(6);
                var lonFormat = parseFloat(item.lon).toFixed(6);
                var namaLokasi = item.display_name;

                // Membuat baris tabel
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="text-center fw-bold">${i + 1}</td>
                    <td class="small">${namaLokasi}</td>
                    <td class="text-center">${latFormat}</td>
                    <td class="text-center">${lonFormat}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary fw-bold" onclick="terbangKeLokasi(${latFormat}, ${lonFormat}, '${namaLokasi.replace(/'/g, "\\'")}')">📍 Pilih</button>
                    </td>
                `;
                tabelBody.appendChild(tr);
            }
        } catch (error) {
            loading.style.display = "none";
            tabelBody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Terjadi kesalahan jaringan saat mengambil data peta.</td></tr>`;
        }
    }

    // Fungsi saat tombol "Pilih" di tabel diklik
    function terbangKeLokasi(lat, lng, namaLokasi) {
        // 1. Pindahkan kamera peta dengan animasi (FlyTo)
        map.flyTo([lat, lng], 16);
        
        // 2. Pindahkan pin
        marker.setLatLng([lat, lng]);
        
        // 3. Ubah isi popup pada pin
        marker.getPopup().setContent("<b>Lokasi Ditemukan:</b><br><span style='font-size:11px;'>" + namaLokasi + "</span>").openPopup();
        
        // 4. Update kotak input HTML otomatis
        document.getElementById('inputLat').value = lat;
        document.getElementById('inputLng').value = lng;
        
        // Gulir layar (scroll) kembali ke atas (area peta)
        document.getElementById('map').scrollIntoView({ behavior: 'smooth' });
    }
</script>

</body>
</html>
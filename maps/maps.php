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
            <p>Sistem Informasi Geografis (SIG) menggunakan OpenStreetMap. Anda dapat mengetik koordinat, mengklik peta, atau menggeser pin secara manual.</p>
            
            <div class="row g-3 mb-4 p-3 bg-light rounded border">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Latitude (Garis Lintang)</label>
                    <input type="text" class="form-control" id="inputLat" value="-6.187311" placeholder="Contoh: -6.187311">
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Longitude (Garis Bujur)</label>
                    <input type="text" class="form-control" id="inputLng" value="106.773329" placeholder="Contoh: 106.773329">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 fw-bold" onclick="updatePetaDariInput()">📍 Update Peta</button>
                </div>
            </div>
            
            <div id="map" class="border"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // 1. Set Koordinat Awal (Default: Universitas Esa Unggul)
    var awalLat = -6.187311;
    var awalLng = 106.773329;

    // 2. Inisialisasi Peta
    var map = L.map('map').setView([awalLat, awalLng], 15);

    // 3. Muat Google/OpenStreetMap Layer Tiles
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // 4. Buat Marker yang Bersifat "draggable: true" (BISA DIGESER MANUAL)
    var marker = L.marker([awalLat, awalLng], { draggable: true }).addTo(map);
    marker.bindPopup("<b>Posisi Terpilih</b><br>Geser pin atau klik peta untuk mengubah posisi.").openPopup();


    // ==========================================
    // LOGIKA METODE MANUAL 1: KETIK DAN TOMBOL UPDATE
    // ==========================================
    function updatePetaDariInput() {
        var lat = parseFloat(document.getElementById('inputLat').value);
        var lng = parseFloat(document.getElementById('inputLng').value);
        
        if (!isNaN(lat) && !isNaN(lng)) {
            marker.setLatLng([lat, lng]); // Pindahkan pin
            map.setView([lat, lng], 16);  // Arahkan fokus kamera peta
            marker.getPopup().setContent("<b>Lokasi Input Manual:</b><br>" + lat + ", " + lng).openPopup();
        } else {
            alert("Harap masukkan format angka koordinat Latitude & Longitude yang valid!");
        }
    }

    // ==========================================
    // LOGIKA METODE MANUAL 2: KLIK DI AREA PETA
    // ==========================================
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        // Otomatis ubah tulisan di kotak input HTML (.toFixed(6) membatasi 6 angka di belakang koma)
        document.getElementById('inputLat').value = lat.toFixed(6);
        document.getElementById('inputLng').value = lng.toFixed(6);

        // Geser pin menuju titik klik tersebut
        marker.setLatLng([lat, lng]);
        marker.getPopup().setContent("<b>Lokasi Terpilih (Klik Peta):</b><br>" + lat.toFixed(6) + ", " + lng.toFixed(6)).openPopup();
    });

    // ==========================================
    // LOGIKA METODE MANUAL 3: PIN DIGESER (DRAG)
    // ==========================================
    marker.on('dragend', function(e) {
        var posisiBaru = marker.getLatLng();
        
        // Isikan koordinat lokasi baru tempat pin dilepas ke dalam form input
        document.getElementById('inputLat').value = posisiBaru.lat.toFixed(6);
        document.getElementById('inputLng').value = posisiBaru.lng.toFixed(6);
        
        marker.getPopup().setContent("<b>Lokasi Terpilih (Geser Pin):</b><br>" + posisiBaru.lat.toFixed(6) + ", " + posisiBaru.lng.toFixed(6)).openPopup();
    });
</script>

</body>
</html>
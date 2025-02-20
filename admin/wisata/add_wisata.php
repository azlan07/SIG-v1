<?php
require_once '../config/auth_check.php';
require_once '../config/crud_logic.php';

// Inisialisasi Database class untuk penggunaan selanjutnya jika diperlukan
$wisataDB = new Database('wisata');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Wisata - Admin Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <?php include '../components/sidebar.php'; ?>

        <div class="body-wrapper">
            <?php include '../components/navbar.php'; ?>

            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="card-title fw-semibold">Tambah Data Wisata</h5>
                            <a href="table_wisata.php" class="btn btn-secondary">
                                <i class="ti ti-arrow-left me-1"></i>
                                Kembali
                            </a>
                        </div>

                        <div class="row">
                            <!-- Form Input -->
                            <div class="col-md-6 mb-4">
                                <form action="add_wisata_action.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="nama_wisata" class="form-label">Nama Wisata</label>
                                        <input type="text" class="form-control" id="nama_wisata" name="nama_wisata"
                                            required placeholder="Masukkan nama wisata">
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="2"
                                            required placeholder="Masukkan alamat lengkap"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                            required placeholder="Masukkan deskripsi wisata"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="harga_tiket" class="form-label">Harga Tiket</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control" id="harga_tiket"
                                                    name="harga_tiket" required min="0">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="banyak_pengunjung" class="form-label">Pengunjung/Bulan</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="banyak_pengunjung"
                                                    name="banyak_pengunjung" required min="0">
                                                <span class="input-group-text">Orang</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="number" class="form-control" id="latitude" name="latitude"
                                                step="any" required placeholder="-0.9632193533203104">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input type="number" class="form-control" id="longitude" name="longitude"
                                                step="any" required placeholder="100.78149209828896">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="foto_wisata" class="form-label">Foto Wisata</label>
                                        <input type="file" class="form-control" id="foto_wisata" name="foto_wisata"
                                            accept="image/*" required>
                                        <div class="form-text">Format: JPG, JPEG, PNG. Maksimal 2MB</div>
                                        <?php if (!empty($data['foto_wisata'])): ?>
                                            <img src="../assets/images/wisata/<?php echo htmlspecialchars($data['foto_wisata']); ?>"
                                                alt="Preview" class="preview-image">
                                        <?php endif; ?>
                                    </div>

                                    <div class="text-start">
                                        <button type="reset" class="btn btn-secondary me-2">
                                            <i class="ti ti-refresh me-1"></i>Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-device-floppy me-1"></i>Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Map Section -->
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title mb-3">Pilih Lokasi Wisata</h6>
                                        <div id="map"></div>
                                        <div class="form-text mt-2">
                                            <i class="ti ti-info-circle me-1"></i>
                                            Klik pada peta atau geser marker untuk menentukan lokasi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include '../components/footer.php'; ?>
            </div>
        </div>
    </div>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-0.9632193533203104, 100.78149209828896], 10);

        // Tambahkan tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan marker default
        var marker = L.marker([-0.9632193533203104, 100.78149209828896], {
            draggable: true
        }).addTo(map);

        // Update form ketika marker dipindahkan
        marker.on('dragend', function(e) {
            updateCoordinates(marker.getLatLng());
        });

        // Tambahkan marker baru ketika peta diklik
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateCoordinates(e.latlng);
        });

        function updateCoordinates(latlng) {
            document.getElementById('latitude').value = latlng.lat.toFixed(8);
            document.getElementById('longitude').value = latlng.lng.toFixed(8);
        }

        // Preview foto sebelum upload
        document.getElementById('foto_wisata').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                if (e.target.files[0].size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB');
                    this.value = '';
                }
            }
        });
    </script>
</body>

</html>
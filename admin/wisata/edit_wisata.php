<?php
require_once '../config/auth_check.php';
require_once '../config/crud_logic.php';

try {
    // Inisialisasi Database class dengan primary key yang sesuai
    $wisataDB = new Database('wisata', 'id_wisata');

    // Cek dan ambil ID dari URL
    if (!isset($_GET['id'])) {
        throw new Exception("ID tidak ditemukan");
    }

    // Ambil data wisata
    $id = $_GET['id'];
    $data = $wisataDB->getById($id);

    if (!$data) {
        throw new Exception("Data wisata tidak ditemukan");
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Error: " . $e->getMessage();
    header('Location: table_wisata.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Wisata - Admin Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .preview-image {
            max-height: 200px;
            width: auto;
            border-radius: 8px;
            margin-top: 10px;
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
                            <h5 class="card-title fw-semibold">Edit Data Wisata</h5>
                            <a href="table_wisata.php" class="btn btn-secondary">
                                <i class="ti ti-arrow-left me-1"></i>
                                Kembali
                            </a>
                        </div>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="edit_wisata_action.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_wisata" value="<?php echo htmlspecialchars($data['id_wisata']); ?>">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_wisata" class="form-label">Nama Wisata</label>
                                        <input type="text" class="form-control" id="nama_wisata" name="nama_wisata"
                                            value="<?php echo htmlspecialchars($data['nama_wisata']); ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat"
                                            rows="2" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi"
                                            rows="3" required><?php echo htmlspecialchars($data['deskripsi']); ?></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="harga_tiket" class="form-label">Harga Tiket</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control" id="harga_tiket" name="harga_tiket"
                                                    value="<?php echo htmlspecialchars($data['harga_tiket']); ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="banyak_pengunjung" class="form-label">Pengunjung/Bulan</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="banyak_pengunjung"
                                                    name="banyak_pengunjung" min="0"
                                                    value="<?php echo htmlspecialchars($data['banyak_pengunjung']); ?>" required>
                                                <span class="input-group-text">Orang</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="foto_wisata" class="form-label">Foto Wisata</label>
                                        <input type="file" class="form-control" id="foto_wisata" name="foto_wisata"
                                            accept="image/*">
                                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto</div>
                                        <?php if (!empty($data['foto_wisata'])): ?>
                                            <img src="../assets/images/wisata/<?php echo htmlspecialchars($data['foto_wisata']); ?>"
                                                alt="Preview" class="preview-image">
                                        <?php endif; ?>
                                    </div>

                                    <div class="text-start mt-4">
                                        <button type="reset" class="btn btn-secondary me-2">
                                            <i class="ti ti-refresh me-1"></i>Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-device-floppy me-1"></i>Simpan
                                        </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h6 class="fw-semibold mb-3">Lokasi Wisata</h6>
                                            <div id="map" class="mb-3"></div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="latitude" class="form-label">Latitude</label>
                                                    <input type="number" class="form-control" id="latitude" name="latitude"
                                                        step="any" value="<?php echo $data['latitude']; ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="longitude" class="form-label">Longitude</label>
                                                    <input type="number" class="form-control" id="longitude" name="longitude"
                                                        step="any" value="<?php echo $data['longitude']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-text">
                                                <i class="ti ti-map-pin me-1"></i>
                                                Klik pada peta untuk memilih lokasi
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tambahkan card informasi update yang sebelumnya dicomment -->
                                    <!-- <div class="card">
                                        <div class="card-body">
                                            <h6 class="fw-semibold mb-3">Informasi Update</h6>
                                            <div class="small">
                                                <div class="mb-2">
                                                    <i class="ti ti-clock me-1"></i> Update Time:
                                                    <span class="text-primary"><?php echo $currentTime; ?></span>
                                                </div>
                                                <div>
                                                    <i class="ti ti-user me-1"></i> Updated By:
                                                    <span class="text-primary"><?php echo $currentUser; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </form>
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
    <script src="../assets/js/dashboard.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Preview foto ketika dipilih
        document.getElementById('foto_wisata').onchange = function(e) {
            const file = this.files[0];
            if (file) {
                if (file.size > 2000000) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.preview-image');
                    if (preview) {
                        preview.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('preview-image');
                        document.getElementById('foto_wisata').parentNode.appendChild(img);
                    }
                }
                reader.readAsDataURL(file);
            }
        };

        // Inisialisasi peta
        var map = L.map('map').setView([<?php echo $data['latitude']; ?>, <?php echo $data['longitude']; ?>], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan marker
        var marker = L.marker([<?php echo $data['latitude']; ?>, <?php echo $data['longitude']; ?>], {
            draggable: true
        }).addTo(map);

        // Update koordinat saat marker dipindah
        marker.on('dragend', function(e) {
            document.getElementById('latitude').value = marker.getLatLng().lat;
            document.getElementById('longitude').value = marker.getLatLng().lng;
        });

        // Update marker saat peta diklik
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat;
            document.getElementById('longitude').value = e.latlng.lng;
        });
    </script>
</body>

</html>
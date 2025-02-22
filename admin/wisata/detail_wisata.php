<?php
require_once '../config/auth_check.php';
require_once '../config/crud_logic.php';

try {
    // Inisialisasi Database class dengan primary key yang sesuai
    $wisataDB = new Database('wisata', 'id_wisata');

    if (!isset($_GET['id'])) {
        throw new Exception("ID tidak ditemukan");
    }

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
        .img-container {
            width: 100%;
            height: 300px;
            /* Tinggi tetap */
            overflow: hidden;
            border-radius: 8px;
            position: relative;
        }

        .img-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Menjaga aspek ratio dan mengisi container */
            object-position: center;
            /* Posisi gambar di tengah */
            display: block;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        /* Hover effect (opsional) */
        .img-container:hover .img-preview {
            transform: scale(1.02);
        }

        /* Style untuk tombol zoom (opsional) */
        .zoom-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        /* Modal untuk tampilan gambar penuh */
        .modal-img {
            max-height: 80vh;
            max-width: 100%;
            object-fit: contain;
        }

        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .detail-table td {
            padding: 12px 15px;
        }

        .detail-table td:first-child {
            font-weight: 500;
            width: 200px;
            background-color: #f8f9fa;
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
                            <h5 class="card-title fw-semibold">Detail Wisata <?php echo htmlspecialchars($data['nama_wisata']); ?></h5>
                            <div class="d-flex gap-2">
                                <a href="table_wisata.php" class="btn btn-secondary">
                                    <i class="ti ti-arrow-left me-1"></i>
                                    Kembali
                                </a>
                                <a href="edit_wisata.php?id=<?php echo $data['id_wisata']; ?>"
                                    class="btn btn-primary"
                                    title="Edit">
                                    <i class="ti ti-edit me-1"></i>
                                    Edit
                                </a>
                                <button type="button"
                                    class="btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal<?php echo $data['id_wisata']; ?>"
                                    title="Hapus">
                                    <i class="ti ti-trash me-1"></i>
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?php echo $data['id_wisata']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus wisata <strong><?php echo htmlspecialchars($data['nama_wisata']); ?></strong>?</p>
                                        <small class="text-muted">
                                            <i class="ti ti-alert-triangle me-1"></i>
                                            Tindakan ini tidak dapat dibatalkan
                                        </small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="ti ti-x me-1"></i>
                                            Batal
                                        </button>
                                        <a href="delete_wisata.php?id=<?php echo $data['id_wisata']; ?>" class="btn btn-danger">
                                            <i class="ti ti-trash me-1"></i>
                                            Hapus
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <table class="table table-bordered detail-table">
                                    <tr>
                                        <td>Nama Wisata</td>
                                        <td><?php echo htmlspecialchars($data['nama_wisata']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td><?php echo nl2br(htmlspecialchars($data['deskripsi'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Harga Tiket</td>
                                        <td>Rp <?php echo number_format($data['harga_tiket'], 0, ',', '.'); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pengunjung per-Bulan</td>
                                        <td><?php echo number_format($data['banyak_pengunjung']); ?> Orang</td>
                                    </tr>
                                    <tr>
                                        <td>Koordinat</td>
                                        <td>
                                            <div>Latitude: <?php echo $data['latitude']; ?></div>
                                            <div>Longitude: <?php echo $data['longitude']; ?></div>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Info Tambahan -->
                                <div class="card mt-4">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-3">Informasi Tambahan</h6>
                                        <div class="small">
                                            <div class="mb-2">
                                                <i class="ti ti-clock me-1"></i> Current Time:<br>
                                                <span class="text-primary"><?php echo $data['updated_at']; ?></span>
                                            </div>
                                            <div>
                                                <i class="ti ti-user me-1"></i> Current User:<br>
                                                <span class="text-primary"><?php echo $data['updated_by']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <!-- Foto Wisata -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-3">Foto Wisata</h6>
                                        <?php if (!empty($data['foto_wisata'])): ?>
                                            <div class="img-container">
                                                <img src="../assets/images/wisata/<?php echo htmlspecialchars($data['foto_wisata']); ?>"
                                                    alt="Foto <?php echo htmlspecialchars($data['nama_wisata']); ?>"
                                                    class="img-preview">
                                                <button type="button"
                                                    class="zoom-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#imageModal">
                                                    <i class="ti ti-zoom-in"></i>
                                                </button>
                                            </div>

                                            <!-- Modal untuk tampilan gambar penuh -->
                                            <div class="modal fade" id="imageModal" tabindex="-1">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <?php echo htmlspecialchars($data['nama_wisata']); ?>
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center p-0">
                                                            <img src="../assets/images/wisata/<?php echo htmlspecialchars($data['foto_wisata']); ?>"
                                                                alt="Foto <?php echo htmlspecialchars($data['nama_wisata']); ?>"
                                                                class="modal-img">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="small text-muted">
                                                                <i class="ti ti-calendar me-1"></i>
                                                                Last updated: <?php echo date('Y-m-d H:i:s'); // 2025-02-18 14:04:07 
                                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-center text-muted py-5">
                                                <i class="ti ti-photo-off fs-1 mb-2"></i>
                                                <p>Tidak ada foto tersedia</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Peta Lokasi -->
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="fw-semibold mb-3">Lokasi Wisata</h6>
                                        <div id="map"></div>
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
    <script src="../assets/js/dashboard.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([<?php echo $data['latitude']; ?>, <?php echo $data['longitude']; ?>], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan marker
        L.marker([<?php echo $data['latitude']; ?>, <?php echo $data['longitude']; ?>])
            .addTo(map)
            .bindPopup("<?php echo htmlspecialchars($data['nama_wisata']); ?>")
            .openPopup();
    </script>
</body>

</html>
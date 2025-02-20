<?php
require_once '../config/auth_check.php';
require_once '../config/crud_logic.php';

try {
    // Inisialisasi Database class dengan tabel wisata
    $wisataDB = new Database('wisata', 'id_wisata');

    // Ambil semua data wisata dengan urutan terbaru
    $result = $wisataDB->getAll(
        [], // tanpa kondisi WHERE
        ['id_wisata' => 'DESC'] // ORDER BY id_wisata DESC
    );

    $error = null; // Reset error karena kita menggunakan try-catch

} catch (PDOException $e) {
    error_log("Error pada table_wisata: " . $e->getMessage());
    $error = "Terjadi kesalahan saat mengambil data. Silakan coba lagi nanti.";
    $result = []; // Set empty array jika terjadi error
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
                            <h5 class="card-title fw-semibold">Data Wisata</h5>
                            <a href="add_wisata.php" class="btn btn-primary">
                                <i class="ti ti-plus me-1"></i>
                                Tambah Data
                            </a>
                        </div>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <table class="table table-hover table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Wisata</th>
                                        <th>Alamat</th>
                                        <th>Harga Tiket</th>
                                        <th>Pengunjung/Bulan</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($result)): // Ganti mysqli_num_rows dengan !empty
                                        $no = 1;
                                        foreach ($result as $w): // Ganti while dengan foreach
                                    ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <a href="detail_wisata.php?id=<?php echo $w['id_wisata']; ?>"
                                                        class="text-primary fw-semibold">
                                                        <?php echo htmlspecialchars($w['nama_wisata']); ?>
                                                    </a>
                                                </td>
                                                <td><?php echo htmlspecialchars($w['alamat']); ?></td>
                                                <td>Rp <?php echo number_format($w['harga_tiket'], 0, ',', '.'); ?></td>
                                                <td><?php echo number_format($w['banyak_pengunjung']); ?> Orang</td>
                                                <td class="text-center">
                                                    <a href="detail_wisata.php?id=<?php echo $w['id_wisata']; ?>"
                                                        class="btn btn-sm btn-success me-1"
                                                        title="Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    <a href="edit_wisata.php?id=<?php echo $w['id_wisata']; ?>"
                                                        class="btn btn-sm btn-primary me-1"
                                                        title="Edit">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal<?php echo $w['id_wisata']; ?>"
                                                        title="Hapus">
                                                        <i class="ti ti-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal<?php echo $w['id_wisata']; ?>" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Apakah Anda yakin ingin menghapus wisata <strong><?php echo htmlspecialchars($w['nama_wisata']); ?></strong>?</p>
                                                                    <small class="text-muted">
                                                                        <i class="ti ti-alert-triangle me-1"></i>
                                                                        Tindakan ini tidak dapat dibatalkan
                                                                    </small>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <a href="delete_wisata.php?id=<?php echo $w['id_wisata']; ?>" class="btn btn-danger">Hapus</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    else:
                                        ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-3">
                                                <div class="text-muted">Belum ada data wisata</div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>

    <script>
        // Auto hide alerts
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const closeButton = alert.querySelector('.btn-close');
                    if (closeButton) {
                        closeButton.click();
                    }
                }, 5000);
            });
        });

        // DataTable
        $(document).ready(function() {
            $('#dataTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                pageLength: 10,
                columnDefs: [{
                    orderable: false,
                    targets: -1
                }]
            });
        });
    </script>
</body>

</html>
<?php
require_once '../config/auth_check.php';
require_once '../config/crud_logic.php';

try {
    // Inisialisasi Database class dengan tabel event
    $eventDB = new Database('event', 'id_event');

    // Ambil semua data event dengan urutan terbaru
    $result = $eventDB->getAll(
        [], // tanpa kondisi WHERE
        ['id_event' => 'DESC'] // ORDER BY id_event DESC
    );

    $error = null; // Reset error karena kita menggunakan try-catch

} catch (PDOException $e) {
    error_log("Error pada table_event: " . $e->getMessage());
    $error = "Terjadi kesalahan saat mengambil data. Silakan coba lagi nanti.";
    $result = []; // Set empty array jika terjadi error
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Event - Admin Dashboard</title>
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
                            <h5 class="card-title fw-semibold">Data Event</h5>
                            <a href="add_event.php" class="btn btn-primary">
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
                                        <th>NO</th>
                                        <th>Nama Event</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Foto</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($result)):
                                        $no = 1;
                                        foreach ($result as $row):
                                            $status_class = $row['status'] == 'aktif' ? 'bg-success' : 'bg-secondary';
                                    ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <a href="detail_event.php?id=<?php echo $row['id_event']; ?>"
                                                        class="text-primary fw-semibold">
                                                        <?php echo htmlspecialchars($row['nama_event']); ?>
                                                    </a>
                                                </td>
                                                <td><?php echo date('d-m-Y', strtotime($row['tanggal_mulai'])); ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($row['tanggal_selesai'])); ?></td>
                                                <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                                <td>
                                                    <span class="badge <?php echo $status_class; ?>">
                                                        <?php echo ucfirst($row['status']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if (!empty($row['foto_event'])): ?>
                                                        <img src="../uploads/events/<?php echo $row['foto_event']; ?>"
                                                            alt="Foto Event"
                                                            class="img-thumbnail"
                                                            style="max-width: 100px;">
                                                    <?php else: ?>
                                                        <span class="text-muted">Tidak ada foto</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="detail_event.php?id=<?php echo $row['id_event']; ?>"
                                                        class="btn btn-sm btn-success me-1"
                                                        title="Detail">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    <a href="edit_event.php?id=<?php echo $row['id_event']; ?>"
                                                        class="btn btn-sm btn-primary me-1"
                                                        title="Edit">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal<?php echo $row['id_event']; ?>"
                                                        title="Hapus">
                                                        <i class="ti ti-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal<?php echo $row['id_event']; ?>" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Apakah Anda yakin ingin menghapus event <strong><?php echo htmlspecialchars($row['nama_event']); ?></strong>?</p>
                                                                    <small class="text-muted">
                                                                        <i class="ti ti-alert-triangle me-1"></i>
                                                                        Tindakan ini tidak dapat dibatalkan
                                                                    </small>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <a href="delete_event.php?id=<?php echo $row['id_event']; ?>" class="btn btn-danger">Hapus</a>
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
                                            <td colspan="8" class="text-center py-3">
                                                <div class="text-muted">Belum ada data event</div>
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
                    targets: [-1, -2] // Disable sorting for action and image columns
                }]
            });
        });
    </script>
</body>

</html>
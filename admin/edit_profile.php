<?php
require_once '../auth_check.php';

require_once '../config/database.php';

// Cek if user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

$success_message = '';
$error_message = '';

// Get current user data
try {
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$_SESSION['admin_username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error mengambil data: " . $e->getMessage();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        // Update Profile Logic
        $nama = trim($_POST['nama']);

        try {
            $stmt = $conn->prepare("UPDATE admin SET nama = ? WHERE username = ?");
            $result = $stmt->execute([$nama, $_SESSION['admin_username']]);

            if ($result) {
                $_SESSION['admin_nama'] = $nama;
                $success_message = "Profile berhasil diupdate!";
                $user['nama'] = $nama; // Update local user data
            } else {
                $error_message = "Gagal mengupdate profile!";
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    } else if (isset($_POST['update_password'])) {
        // Update Password Logic
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate current password
        if (!password_verify($current_password, $user['password'])) {
            $error_message = "Password saat ini tidak sesuai!";
        }
        // Validate new password
        else if ($new_password !== $confirm_password) {
            $error_message = "Password baru dan konfirmasi tidak cocok!";
        } else if (strlen($new_password) < 8) {
            $error_message = "Password baru minimal 8 karakter!";
        } else {
            try {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE username = ?");
                $result = $stmt->execute([$hashed_password, $_SESSION['admin_username']]);

                if ($result) {
                    $success_message = "Password berhasil diupdate!";
                } else {
                    $error_message = "Gagal mengupdate password!";
                }
            } catch (PDOException $e) {
                $error_message = "Error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Font Awesome untuk icons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> -->

    <!-- Custom Styling -->
    <link rel="shortcut icon" type="image/png" href="./assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="./assets/css/styles.min.css" />

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Include Sidebar -->
        <?php include 'components/sidebar.php'; ?>

        <!--  Main wrapper -->
        <div class="body-wrapper">

            <!-- Include Navbar -->
            <?php include 'components/navbar.php'; ?>

            <div class="container-fluid">
                <div class="card">
                    <?php if ($success_message): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($error_message): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Edit Profile & Password</h5>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab">Edit Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#password" role="tab">Ganti Password</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Edit Profile Tab -->
                        <div class="tab-pane active" id="profile" role="tabpanel">
                            <form id="profileForm" method="POST">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username"
                                        value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                                    <small class="text-muted">Username tidak dapat diubah</small>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                                </div>
                                <div class="text-end">
                                    <button type="submit" name="update_profile" class="btn btn-primary">
                                        <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane" id="password" role="tabpanel">
                            <form id="passwordForm" method="POST">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" required>
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('current_password')">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password" required>
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('new_password')">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                    <div class="password-strength mt-2" id="password-strength"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" required>
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePassword('confirm_password')">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" name="update_password" class="btn btn-primary">
                                        <i class="ti ti-key me-1"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Include Footer -->
                <?php include 'components/footer.php'; ?>

            </div>
        </div>
    </div>

    <!-- Custom Script -->
    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./assets/js/sidebarmenu.js"></script>
    <script src="./assets/js/app.min.js"></script>
    <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="./assets/js/dashboard.js"></script>

    <!-- Bootstrap JS and dependencies -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- Add jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
</body>

</html>
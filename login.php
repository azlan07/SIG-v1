<?php
session_start();
require_once 'config/database.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: admin/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = 'Silakan isi semua field';
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_nama'] = $user['nama'];
                $_SESSION['admin_username'] = $user['username'];

                header('Location: admin/index.php');
                exit;
            } else {
                $error = 'Username atau password salah';
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - SIG Wisata</title>
    <link rel="shortcut icon" type="image/png" href="admin/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="admin/assets/css/styles.min.css" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="brand-logo text-center">
                                    <a href="index.php" class="logo-container d-inline-block">
                                        <div class="logo-wrapper">
                                            <i class="ti ti-globe globe-icon"></i>
                                            <span class="logo-text">SIG</span>
                                        </div>
                                    </a>

                                    <style>
                                        .brand-logo {
                                            padding: 10px 0;
                                            margin-bottom: 20px;
                                        }

                                        .logo-container {
                                            display: inline-flex;
                                            align-items: center;
                                            padding: 10px 20px;
                                            text-decoration: none;
                                            transition: all 0.3s ease;
                                        }

                                        .logo-wrapper {
                                            display: flex;
                                            align-items: center;
                                            gap: 12px;
                                        }

                                        .globe-icon {
                                            font-size: 28px;
                                            color: #5D87FF;
                                            transition: all 0.5s ease;
                                        }

                                        .logo-text {
                                            font-size: 24px;
                                            font-weight: 700;
                                            color: #2a3547;
                                            letter-spacing: 1px;
                                            transition: all 0.3s ease;
                                        }

                                        .logo-container:hover .globe-icon {
                                            transform: rotate(360deg);
                                            color: #2a3547;
                                        }

                                        .logo-container:hover .logo-text {
                                            color: #5D87FF;
                                            transform: scale(1.05);
                                        }
                                    </style>
                                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                                        <i class="ti ti-x fs-8"></i>
                                    </div>
                                </div>
                                <p class="text-center">Login Admin SIG Wisata</p>

                                <?php if ($error): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo $error; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>

                                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text"
                                            class="form-control"
                                            id="username"
                                            name="username"
                                            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password"
                                                class="form-control"
                                                id="password"
                                                name="password"
                                                required>
                                            <button class="btn btn-outline-secondary"
                                                type="button"
                                                id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
                                        Login
                                    </button>
                                    <div class="d-flex align-items-center justify-content-center gap-3 mb-4">
                                        <span>Belum punya akun?</span>
                                        <a href="register.php" class="text-primary fw-bold">Register</a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a class="text-primary fw-bold" href="index.php">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="admin/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="admin/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');

            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        // Auto-hide alert after 5 seconds
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }, 5000);
        }
    </script>
</body>

</html>
<?php
session_start();
require_once 'config/database.php';

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($nama) || empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Silakan isi semua field';
    } elseif ($password !== $confirm_password) {
        $error = 'Password tidak cocok';
    } else {
        try {
            // Cek username sudah digunakan atau belum
            $stmt = $conn->prepare("SELECT COUNT(*) FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            $count = $stmt->fetchColumn();
            
            if ($count > 0) {
                $error = 'Username sudah digunakan';
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert user baru
                $stmt = $conn->prepare("INSERT INTO admin (nama, username, password) VALUES (?, ?, ?)");
                $stmt->execute([$nama, $username, $hashed_password]);
                
                $success = 'Registrasi berhasil! Silakan login';
            }
        } catch(PDOException $e) {
            $error = 'Terjadi kesalahan: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            max-width: 400px;
            margin: 50px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Register Admin</h3>
                    
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="login.php">Sudah punya akun? Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
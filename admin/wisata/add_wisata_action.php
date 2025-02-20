<?php
require_once '../config/auth_check.php';
require_once '../config/crud_logic.php';

try {
    // Inisialisasi Database class
    $wisataDB = new Database('wisata');

    // Sanitasi input
    $data = [
        'nama_wisata' => htmlspecialchars($_POST['nama_wisata']),
        'alamat' => htmlspecialchars($_POST['alamat']),
        'deskripsi' => htmlspecialchars($_POST['deskripsi']),
        'harga_tiket' => (int)$_POST['harga_tiket'],
        'banyak_pengunjung' => (int)$_POST['banyak_pengunjung'],
        'latitude' => (float)$_POST['latitude'],
        'longitude' => (float)$_POST['longitude'],
        'created_by' => $_SESSION['admin_username'],
        'updated_by' => $_SESSION['admin_username']
    ];

    // Handle file upload
    if (isset($_FILES['foto_wisata']) && $_FILES['foto_wisata']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['foto_wisata'];

        // Validasi ukuran file (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran file terlalu besar! Maksimal 2MB");
        }

        // Validasi tipe file
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime_type, $allowed_types)) {
            throw new Exception("Tipe file harus JPG atau PNG");
        }

        // Generate unique filename
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $new_filename = date('Ymd_His') . '_' . uniqid() . '.' . $extension;

        // Upload path
        $upload_path = '../assets/images/wisata/';
        if (!is_dir($upload_path)) {
            if (!mkdir($upload_path, 0755, true)) {
                throw new Exception("Gagal membuat direktori upload");
            }
        }

        // Upload file
        if (!move_uploaded_file($file['tmp_name'], $upload_path . $new_filename)) {
            throw new Exception("Gagal mengupload file");
        }

        $data['foto_wisata'] = $new_filename;
    }

    // Mulai transaction
    $wisataDB->beginTransaction();

    // Insert data
    $id = $wisataDB->create($data);

    // Commit transaction
    $wisataDB->commit();

    $_SESSION['success'] = "Data wisata berhasil ditambahkan!";
    header("Location: table_wisata.php");
    exit;
} catch (Exception $e) {
    // Rollback transaction
    if (isset($wisataDB)) {
        $wisataDB->rollback();
    }

    // Hapus file yang sudah diupload jika ada error
    if (isset($new_filename) && file_exists($upload_path . $new_filename)) {
        unlink($upload_path . $new_filename);
    }

    $_SESSION['error'] = "Error: " . $e->getMessage();
    header("Location: add_wisata.php");
    exit;
}

<?php
require_once '../config/auth_check.php';
require_once '../config/crud_logic.php';

try {
    // Cek ID
    if (!isset($_GET['id'])) {
        throw new Exception("ID tidak ditemukan");
    }

    // Inisialisasi Database class dengan primary key yang sesuai
    $wisataDB = new Database('wisata', 'id_wisata');

    $id = $_GET['id'];

    // Ambil data wisata untuk mendapatkan info foto
    $data = $wisataDB->getById($id);
    if (!$data) {
        throw new Exception("Data wisata tidak ditemukan");
    }

    // Path foto
    $foto_path = "../assets/images/wisata/" . $data['foto_wisata'];

    // Mulai transaction
    $wisataDB->beginTransaction();

    // Hapus data dari database
    if (!$wisataDB->delete($id)) {
        throw new Exception("Gagal menghapus data dari database");
    }

    // Hapus file foto jika ada
    if (!empty($data['foto_wisata']) && file_exists($foto_path)) {
        if (!unlink($foto_path)) {
            throw new Exception("Gagal menghapus file foto");
        }
    }

    // Commit transaction
    $wisataDB->commit();

    $_SESSION['success'] = "Data wisata berhasil dihapus!";
} catch (Exception $e) {
    // Rollback transaction jika terjadi error
    if (isset($wisataDB)) {
        $wisataDB->rollback();
    }

    $_SESSION['error'] = "Error: " . $e->getMessage();
} finally {
    // Redirect kembali ke table_wisata.php
    header("Location: table_wisata.php");
    exit;
}

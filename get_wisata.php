<?php
require_once 'config/database.php';

header('Content-Type: application/json');

try {
    $stmt = $conn->prepare("SELECT id_wisata, nama_wisata, alamat, deskripsi, harga_tiket, latitude, longitude, foto_wisata FROM wisata");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($result);
} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
<?php
require_once 'config/database.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM wisata WHERE id_wisata = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode($result);
    } catch(PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'ID tidak ditemukan']);
}
?>
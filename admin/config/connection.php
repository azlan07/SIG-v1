<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$name = "db_sig";

try {
    // Membuat koneksi PDO
    $koneksi = new PDO(
        "mysql:host=$host;dbname=$name;charset=utf8mb4", 
        $user, 
        $pass, 
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
        ]
    );

    $koneksi->exec("SET time_zone = '+07:00'");

    // Catat koneksi berhasil
    error_log("Database berhasil terkoneksi...", 0);

} catch(PDOException $e) {
    error_log("Koneksi gagal: " . $e->getMessage(), 0);
    die("Koneksi database gagal! Silahkan hubungi administrator.");
}
?>
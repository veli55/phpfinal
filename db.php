<?php
$host = 'localhost';  // Veritabanı host adı
$dbname = 'kitaplar'; // Veritabanı adı
$username = 'root';    // Kullanıcı adı
$password = 'your_password ';        // Şifre

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}
?>
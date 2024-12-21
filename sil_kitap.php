<?php
include 'db.php';

// Kitap ID'sini URL'den al
if (isset($_GET['kitap_id'])) {
    $kitap_id = $_GET['kitap_id'];  // URL'den kitap_id'yi al

    // Silme işlemi
    $sql = "DELETE FROM kitaplar WHERE id = :kitap_id";  // ID'yi kullanarak silme işlemi yapıyoruz
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kitap_id', $kitap_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<div>Kitap başarıyla silindi!</div>";
        echo "<a href='kitaplari_listele.php'>Kitapları Listele</a>"; // Silme işlemi sonrası kitapları listeleme sayfasına yönlendirme
    } else {
        echo "<div>Bir hata oluştu!</div>";
    }
} else {
    echo "Kitap ID parametresi eksik!";
    exit;
}
?>

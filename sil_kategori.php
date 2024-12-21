<?php
include 'db.php';

// Kategori ID'sini al
if (isset($_GET['kategori_id'])) {
    $kategori_id = $_GET['kategori_id'];

    // Kategoriyi sil
    $sql = "DELETE FROM kategoriler WHERE kategori_id = :kategori_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kategori_id', $kategori_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Kategori başarıyla silindi!";
        header("Location: kategori_listele.php"); // Silme işlemi sonrası liste sayfasına yönlendir
    } else {
        echo "Kategori silinirken bir hata oluştu!";
    }
}
?>

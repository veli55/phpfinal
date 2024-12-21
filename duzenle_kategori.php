<?php
include 'db.php';

// Kategori ID'sini al
if (isset($_GET['kategori_id'])) {
    $kategori_id = $_GET['kategori_id'];

    // Kategori verisini al
    $sql = "SELECT * FROM kategoriler WHERE kategori_id = :kategori_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kategori_id', $kategori_id, PDO::PARAM_INT);
    $stmt->execute();
    $kategori = $stmt->fetch();

    if (!$kategori) {
        echo "Kategori bulunamadı!";
        exit;
    }

    // Form gönderildiğinde güncelleme işlemi yapılacak
    if (isset($_POST['submit'])) {
        $kategori_ad = $_POST['kategori_ad'];

        // Kategoriyi güncelle
        $sql = "UPDATE kategoriler SET kategori_ad = :kategori_ad WHERE kategori_id = :kategori_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':kategori_ad', $kategori_ad);
        $stmt->bindParam(':kategori_id', $kategori_id);
        
        if ($stmt->execute()) {
            echo "Kategori başarıyla güncellendi!";
        } else {
            echo "Kategori güncellenirken bir hata oluştu!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Düzenle</title>
    <link rel="stylesheet" href="kitapekle.css">
</head>
<body>
<form action="duzenle_kategori.php?kategori_id=<?php echo $kategori['kategori_id']; ?>" method="post">
    <label for="kategori_ad">Kategori Adı:</label>
    <input type="text" name="kategori_ad" value="<?php echo htmlspecialchars($kategori['kategori_ad']); ?>" required><br><br>
    <input type="submit" name="submit" value="Güncelle">
</form>

</body>
</html>

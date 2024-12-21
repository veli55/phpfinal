<?php
include 'db.php'; // Veritabanı bağlantısını dahil et

// Kategori ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kategori adı al
    $kategori_ad = $_POST['kategori_ad'];

    // Kategori adı boşsa hata ver
    if (empty($kategori_ad)) {
        $error = "Kategori adı boş olamaz!";
    } else {
        // Kategoriyi veritabanına ekle
        $sql = "INSERT INTO kategoriler (kategori_ad) VALUES (:kategori_ad)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':kategori_ad', $kategori_ad);

        if ($stmt->execute()) {
            $success = "Kategori başarıyla eklendi!";
        } else {
            $error = "Kategori eklenirken bir hata oluştu.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Ekle</title>
    <link rel="stylesheet" href="kitapekle.css">
</head>
<body>
<!-- Başarı veya hata mesajı gösterme -->
<?php if (isset($success)): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php endif; ?>

<!-- Kategori ekleme formu -->
<form action="kategori_ekle.php" method="post">
    <label for="kategori_ad">Kategori Adı:</label>
    <input type="text" id="kategori_ad" name="kategori_ad" required>

    <button type="submit">Kategori Ekle</button>
</form>

</body>
</html>

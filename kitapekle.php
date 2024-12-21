<?php
include 'db.php';

// Kategorileri al
$sql = "SELECT * FROM kategoriler";
$stmt = $pdo->query($sql);
$kategoriler = $stmt->fetchAll();

// Kitap ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri alıyoruz
    $kitap_ad = $_POST['kitap_ad'];
    $kitap_aciklama = $_POST['kitap_aciklama'];
    $kitap_yazar = $_POST['kitap_yazar'];
    $kategori_id = $_POST['kategori_id'];

    // Kitap resmi dosyasını yüklemek
    $kitap_resim = $_FILES['kitap_resim']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($kitap_resim);
    move_uploaded_file($_FILES['kitap_resim']['tmp_name'], $target_file);

    // Veritabanına eklemek için SQL sorgusu
    $sql = "INSERT INTO kitaplar (kitap_ad, kitap_aciklama, kitap_yazar, kitap_resim, kategori_id) 
            VALUES (:kitap_ad, :kitap_aciklama, :kitap_yazar, :kitap_resim, :kategori_id)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kitap_ad', $kitap_ad);
    $stmt->bindParam(':kitap_aciklama', $kitap_aciklama);
    $stmt->bindParam(':kitap_yazar', $kitap_yazar);
    $stmt->bindParam(':kitap_resim', $kitap_resim);
    $stmt->bindParam(':kategori_id', $kategori_id);

    if ($stmt->execute()) {
        echo "<div>Kitap başarıyla eklendi!</div>";
    } else {
        echo "<div>Bir hata oluştu!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitap Ekle</title>
    <link rel="stylesheet" href="kitapekle.css">
</head>
<body>
<form action="kitapekle.php" method="post" enctype="multipart/form-data">
    <label for="kitap_ad">Kitap Adı:</label>
    <input type="text" name="kitap_ad" required><br><br>
    
    <label for="kitap_aciklama">Açıklama:</label>
    <textarea name="kitap_aciklama" required></textarea><br><br>
    
    <label for="kitap_yazar">Yazar:</label>
    <input type="text" name="kitap_yazar" required><br><br>
    
    <label for="kategori_id">Kategori:</label>
    <select name="kategori_id" required>
        <?php foreach ($kategoriler as $kategori): ?>
            <option value="<?php echo $kategori['kategori_id']; ?>"><?php echo $kategori['kategori_ad']; ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="kitap_resim">Kitap Resmi:</label>
    <input type="file" name="kitap_resim" required><br><br>

    <input type="submit" value="Kitap Ekle">
</form>

</body>
</html>

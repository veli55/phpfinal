<?php
include 'db.php';

// Kitap ID'yi URL'den al ve kitap verilerini çek
if (isset($_GET['kitap_id'])) {
    $kitap_id = $_GET['kitap_id'];
    $sql = "SELECT * FROM kitaplar WHERE id = :kitap_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kitap_id', $kitap_id, PDO::PARAM_INT);
    $stmt->execute();
    $kitap = $stmt->fetch();

    if ($kitap) {
        // Kitap verilerini formda göstermek için alıyoruz
        $kitap_ad = $kitap['kitap_ad'];
        $kitap_aciklama = $kitap['kitap_aciklama'];
        $kitap_yazar = $kitap['kitap_yazar'];
        $kategori_id = $kitap['kategori_id'];
        $kitap_resim = $kitap['kitap_resim'];
    } else {
        die("Kitap bulunamadı!");
    }
} else {
    die("Kitap ID parametresi eksik!");
}

// Kitap düzenleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kitap_ad = $_POST['kitap_ad'];
    $kitap_aciklama = $_POST['kitap_aciklama'];
    $kitap_yazar = $_POST['kitap_yazar'];
    $kategori_id = $_POST['kategori_id'];

    // Resim işlemi (varsa yükle)
    if ($_FILES['kitap_resim']['name']) {
        $kitap_resim = $_FILES['kitap_resim']['name'];
        move_uploaded_file($_FILES['kitap_resim']['tmp_name'], "uploads/" . $kitap_resim);
    } else {
        $kitap_resim = $kitap_resim;  // Eski resmi kullan
    }

    // Veritabanını güncelle
    $sql = "UPDATE kitaplar SET kitap_ad = :kitap_ad, kitap_aciklama = :kitap_aciklama, kitap_yazar = :kitap_yazar, 
            kitap_resim = :kitap_resim, kategori_id = :kategori_id WHERE kitap_id = :kitap_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kitap_ad', $kitap_ad);
    $stmt->bindParam(':kitap_aciklama', $kitap_aciklama);
    $stmt->bindParam(':kitap_yazar', $kitap_yazar);
    $stmt->bindParam(':kitap_resim', $kitap_resim);
    $stmt->bindParam(':kategori_id', $kategori_id);
    $stmt->bindParam(':kitap_id', $kitap_id);

    if ($stmt->execute()) {
        echo "Kitap başarıyla güncellendi!";
    } else {
        echo "Bir hata oluştu!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitap Düzenle</title>
    <link rel="stylesheet" href="kitapekle.css">
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <label for="kitap_ad">Kitap Adı:</label>
    <input type="text" name="kitap_ad" value="<?php echo htmlspecialchars($kitap_ad); ?>" required><br><br>

    <label for="kitap_aciklama">Açıklama:</label>
    <textarea name="kitap_aciklama" required><?php echo htmlspecialchars($kitap_aciklama); ?></textarea><br><br>

    <label for="kitap_yazar">Yazar:</label>
    <input type="text" name="kitap_yazar" value="<?php echo htmlspecialchars($kitap_yazar); ?>" required><br><br>

    <label for="kategori_id">Kategori:</label>
    <select name="kategori_id" required>
        <?php 
        $sql = "SELECT * FROM kategoriler";
        $stmt = $pdo->query($sql);
        $kategoriler = $stmt->fetchAll();
        foreach ($kategoriler as $kategori): ?>
            <option value="<?php echo $kategori['kategori_id']; ?>" <?php echo ($kategori['kategori_id'] == $kategori_id) ? 'selected' : ''; ?>>
                <?php echo $kategori['kategori_ad']; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="kitap_resim">Kitap Resmi:</label>
    <input type="file" name="kitap_resim"><br><br>

    <input type="submit" value="Kitap Düzenle">
</form>
</body>
</html>
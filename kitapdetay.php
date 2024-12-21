<?php
include 'db.php';

// Kitap ID'sini al
$kitap_id = $_GET['id'] ?? null;

if (!$kitap_id) {
    die('Geçersiz kitap ID');
}

// Kitap bilgilerini al
$sql = "SELECT kitaplar.*, kategoriler.kategori_ad 
        FROM kitaplar 
        INNER JOIN kategoriler ON kitaplar.kategori_id = kategoriler.kategori_id 
        WHERE kitaplar.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$kitap_id]);
$kitap = $stmt->fetch();

if (!$kitap) {
    die('Kitap bulunamadı');
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitap Detayı - <?php echo htmlspecialchars($kitap['kitap_ad']); ?></title>
    <link rel="stylesheet" href="kitapdetay.css">
</head>
<body>

<!-- Navbar Başlangıç -->
<div class="navbar">
    <ul>
        <li><a href="kullanıcıişlem.php">Çıkış Yap</a></li>
    </ul>
</div>
<!-- Navbar Bitiş -->

<div class="kitap-detay-container">
    <div class="kitap-resim">
        <?php if (isset($kitap['kitap_resim']) && $kitap['kitap_resim']): ?>
            <img src="uploads/<?php echo htmlspecialchars($kitap['kitap_resim']); ?>" alt="Kitap Resmi">
        <?php else: ?>
            <span>Resim Yok</span>
        <?php endif; ?>
    </div>
    
    <div class="kitap-detay">
        <h1><?php echo htmlspecialchars($kitap['kitap_ad']); ?></h1>
        <p><strong>Yazar:</strong> <?php echo htmlspecialchars($kitap['kitap_yazar']); ?></p>
        <p><strong>Kategori:</strong> <?php echo htmlspecialchars($kitap['kategori_ad']); ?></p>
        <p><strong>Açıklama:</strong> <?php echo nl2br(htmlspecialchars($kitap['kitap_aciklama'])); ?></p>
        <a href="anasayfa.php" class="geri-link">Geri Dön</a>
    </div>
</div>

</body>
</html>

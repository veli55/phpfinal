<?php
include 'db.php';

// Filtreleme parametrelerini alıyoruz
$kategoriId = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$yazar = isset($_GET['yazar']) ? $_GET['yazar'] : '';

// SQL sorgusunu oluşturuyoruz
$sql = "SELECT kitaplar.*, kategoriler.kategori_ad 
        FROM kitaplar 
        INNER JOIN kategoriler 
        ON kitaplar.kategori_id = kategoriler.kategori_id 
        WHERE 1=1";

// Eğer kategoriId varsa, sorguya dahil ediyoruz
if ($kategoriId) {
    $sql .= " AND kitaplar.kategori_id = :kategoriId";
}

// Eğer yazar varsa, sorguya dahil ediyoruz
if ($yazar) {
    $sql .= " AND kitaplar.kitap_yazar LIKE :yazar";
}

$stmt = $pdo->prepare($sql);

// Parametreleri bağlıyoruz
if ($kategoriId) {
    $stmt->bindParam(':kategoriId', $kategoriId, PDO::PARAM_INT);
}

// Eğer yazar varsa, parametreyi bağlıyoruz
if ($yazar) {
    $yazar = "%$yazar%"; // % işaretini burada ekliyoruz
    $stmt->bindParam(':yazar', $yazar, PDO::PARAM_STR);
}

$stmt->execute();
$kitaplar = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitapları Listele</title>
    <link rel="stylesheet" href="/kullanıcısayfası.css">
</head>
<body>

<!-- Navbar Başlangıç -->
<div class="navbar">
    <ul>
        <li><a href="kullanıcıişlem.php">Giriş Yap</a></li>
    </ul>
</div>
<!-- Navbar Bitiş -->

<!-- Filtreleme Formu Başlangıç -->
<div class="filtre-container">
    <form method="GET" action="anasayfa.php">
        <label for="kategori">Kategori:</label>
        <select name="kategori" id="kategori">
            <option value="">Tüm Kategoriler</option>
            <?php 
            $kategoriSql = "SELECT * FROM kategoriler";
            $kategoriStmt = $pdo->query($kategoriSql);
            $kategoriler = $kategoriStmt->fetchAll();
            foreach ($kategoriler as $kategori): 
            ?>
                <option value="<?php echo $kategori['kategori_id']; ?>" <?php echo ($kategoriId == $kategori['kategori_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($kategori['kategori_ad']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label for="yazar">Yazar:</label>
        <input type="text" name="yazar" id="yazar" placeholder="Yazar adı girin" value="<?php echo htmlspecialchars($yazar); ?>">
        
        <button type="submit">Filtrele</button>
    </form>
</div>
<!-- Filtreleme Formu Bitiş -->

<!-- Kitaplar Container Başlangıç -->
<div class="kitaplar-container">
    <?php foreach ($kitaplar as $kitap): ?>
    <div class="kitap-card">
        <div class="kitap-resim">
            <?php if (isset($kitap['kitap_resim']) && $kitap['kitap_resim']): ?>
                <img src="uploads/<?php echo htmlspecialchars($kitap['kitap_resim']); ?>" alt="Kitap Resmi">
            <?php else: ?>
                <span>Resim yok</span>
            <?php endif; ?>
        </div>
        <div class="kitap-detay">
            <h3><?php echo htmlspecialchars($kitap['kitap_ad']); ?></h3>
            <p><strong>Yazar:</strong> <?php echo htmlspecialchars($kitap['kitap_yazar']); ?></p>
            <p><strong>Kategori:</strong> <?php echo htmlspecialchars($kitap['kategori_ad']); ?></p>
            <a href="kitapdetay.php?id=<?php echo $kitap['id']; ?>" class="detay-link">Detayı Görüntüle</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<!-- Kitaplar Container Bitiş -->

</body>
</html>

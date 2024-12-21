<?php
include 'db.php';

// Kitapları al
$sql = "SELECT kitaplar.*, kategoriler.kategori_ad 
        FROM kitaplar 
        INNER JOIN kategoriler ON kitaplar.kategori_id = kategoriler.kategori_id";
$stmt = $pdo->query($sql);
$kitaplar = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitapları Listele</title>
    <link rel="stylesheet" href="kitaplistele.css">
</head>
<body>

<!-- Navbar Başlangıç -->
<div class="navbar">
    <ul>
        <li><a href="kitapekle.php">Kitap Ekle</a></li>
        <li><a href="kitapduzenle.php">kitapları Düzenle</a></li>
        <li><a href="kitapsil.php">Kitap Sil</a></li>
        <li><a href="kategorislem.php">Kategori İşlemeri</a></li>
        <li><a href="cikis.php">Çıkış</a></li>
    </ul>
</div>
<!-- Navbar Bitiş -->

<h2>Kitapları Listele</h2>

<table border="1">
    <thead>
        <tr>
            <th>Kitap Adı</th>
            <th>Yazar</th>
            <th>Açıklama</th>
            <th>Kategori</th>
            <th>Kitap Resmi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($kitaplar as $kitap): ?>
    <tr>
        <td><?php echo isset($kitap['kitap_ad']) ? htmlspecialchars($kitap['kitap_ad']) : 'Bilinmeyen'; ?></td>
        <td><?php echo isset($kitap['kitap_yazar']) ? htmlspecialchars($kitap['kitap_yazar']) : 'Bilinmeyen'; ?></td>
        <td><?php echo isset($kitap['kitap_aciklama']) ? htmlspecialchars(substr($kitap['kitap_aciklama'], 0, 50)) : 'Bilinmeyen'; ?>...</td>
        <td><?php echo isset($kitap['kategori_ad']) ? htmlspecialchars($kitap['kategori_ad']) : 'Bilinmeyen'; ?></td>
        <td>
            <?php if (isset($kitap['kitap_resim']) && $kitap['kitap_resim']): ?>
                <img src="uploads/<?php echo htmlspecialchars($kitap['kitap_resim']); ?>" alt="Kitap Resmi" width="50">
            <?php else: ?>
                <span>Resim yok</span>
            <?php endif; ?>
        </td>

    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

<?php
include 'db.php';

// Kategorileri al
$sql = "SELECT * FROM kategoriler";
$stmt = $pdo->query($sql);
$kategoriler = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorileri Listele</title>
    <link rel="stylesheet" href="/projeee/kategori.css">
</head>
<body>

<h2>Kategorileri Listele</h2>

<table border="1">
    <thead>
        <tr>
            <th>Kategori Adı</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($kategoriler as $kategori): ?>
    <tr>
        <td><?php echo htmlspecialchars($kategori['kategori_ad']); ?></td>
        <td>
            <a href="duzenle_kategori.php?kategori_id=<?php echo $kategori['kategori_id']; ?>">Düzenle</a> |
            <a href="ekle_kategori.php?kategori_id=<?php echo $kategori['kategori_id']; ?>">ekle</a> |
            <a href="sil_kategori.php?kategori_id=<?php echo $kategori['kategori_id']; ?>" onclick="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?');">Sil</a>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

<?php
// Veritabanı bağlantısını dahil ediyoruz
include 'db.php';
session_start(); // Session başlatıyoruz

// Kayıt işlemi
if (isset($_POST['ad']) && isset($_POST['kullanici_adi']) && isset($_POST['sifre'])) {
    $ad = $_POST['ad'];
    $kullanici_adi = $_POST['kullanici_adi'];
    $sifre = $_POST['sifre'];

    // Şifrenin güvenliği için hash'leme işlemi yapıyoruz
    $hashed_password = password_hash($sifre, PASSWORD_DEFAULT);

    try {
        // Kullanıcıyı veritabanına ekliyoruz
        $sql = "INSERT INTO kullanicilar (ad_soyad, kullanici_adi, sifre) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ad, $kullanici_adi, $hashed_password]);

        // Kayıt işlemi başarılı olduğunda kullanıcıyı giriş sayfasına yönlendiriyoruz
        header('Location: kullanıcıişlem.php');
        exit;
    } catch (PDOException $e) {
        die("Kayıt işlemi sırasında hata oluştu: " . $e->getMessage());
    }
}

// Giriş işlemi
if (isset($_POST['kullanici_adi']) && isset($_POST['sifre'])) {
    $kullanici_adi = $_POST['kullanici_adi'];
    $sifre = $_POST['sifre'];

    // Admin kontrolü ekliyoruz
    if ($kullanici_adi === 'admin' && $sifre === 'admin123') {
        // Admin girişinde direkt admin sayfasına yönlendiriyoruz
        $_SESSION['user_id'] = 0;  // Admin için kullanıcı ID'sini özel olarak 0 yapabiliriz
        $_SESSION['user_name'] = 'Admin Kullanıcı';

        header('Location: kitaplari_listele.php'); // Admin sayfasına yönlendiriyoruz
        exit;
    }

    // Kullanıcıyı veritabanında arıyoruz
    $sql = "SELECT * FROM kullanicilar WHERE kullanici_adi = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$kullanici_adi]);
    $user = $stmt->fetch();

    if ($user && password_verify($sifre, $user['sifre'])) {
        // Şifre doğruysa, oturum başlatıyoruz
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['ad'];

        // Kullanıcıyı ana sayfaya yönlendiriyoruz
        header('Location: kullanıcıSayfası.php');
        exit;
    } else {
        // Hatalı giriş durumunda uyarı mesajı
        $error = "Geçersiz kullanıcı adı veya şifre!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kullanıcı Giriş / Kayıt</title>
    <link rel="stylesheet" href="kullanıcıgiris.css">
</head>
<body>
<!-- Kullanıcı Giriş Formu -->
<div class="auth-container">
    <div class="form-container" id="giris-form">
        <h2>Kullanıcı Girişi</h2>
        <form action="kullanıcıişlem.php" method="POST">
            <label for="text">Kullanıcı Adı:</label>
            <input type="text" id="kullanici_adi" name="kullanici_adi" required>
            
            <label for="sifre">Şifre:</label>
            <input type="password" id="sifre" name="sifre" required>
            
            <button type="submit">Giriş Yap</button>
        </form>
        <p><a href="#" id="kayit-link">Kayıt Ol</a></p>
    </div>

    <!-- Kullanıcı Kayıt Formu (JavaScript ile Gösterilecek) -->
    <div class="form-container" id="kayit-form" style="display: none;">
        <h2>Kayıt Ol</h2>
        <form action="kullanıcıişlem.php" method="POST">
            <label for="ad">Ad Soyad:</label>
            <input type="text" id="ad" name="ad" required>
            
            <label for="kullanici_adi">Kullanıcı Adı:</label>
            <input type="text" id="kullanici_adi" name="kullanici_adi" required>
            
            <label for="sifre">Şifre:</label>
            <input type="password" id="sifre_kayit" name="sifre" required>
            
            <button type="submit">Kayıt Ol</button>
        </form>
        <p><a href="#" id="giris-link">Zaten hesabım var</a></p>
    </div>
</div>

<script src="kullanıcıgiris.js"></script>
</body>
</html>

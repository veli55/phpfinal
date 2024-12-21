// Giriş ve Kayıt formu alanları
const girisForm = document.getElementById('giris-form');
const kayitForm = document.getElementById('kayit-form');

// Kayıt formunu açmak için "Kayıt Ol" bağlantısını tıklama
document.getElementById('kayit-link').addEventListener('click', function(e) {
    e.preventDefault();
    girisForm.style.display = 'none';  // Giriş formunu gizle
    kayitForm.style.display = 'block'; // Kayıt formunu göster
});

// Giriş formunu açmak için "Zaten hesabım var" bağlantısını tıklama
document.getElementById('giris-link').addEventListener('click', function(e) {
    e.preventDefault();
    kayitForm.style.display = 'none';  // Kayıt formunu gizle
    girisForm.style.display = 'block'; // Giriş formunu göster
});

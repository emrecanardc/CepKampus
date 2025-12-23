<?php
// db.php - Veritabanı Bağlantı Dosyası

$host = 'localhost';
$dbname = 'universite_kulup_sistemi'; // phpMyAdmin'de oluşturduğumuz veritabanı adı
$username = 'root';       // XAMPP varsayılan kullanıcı adı
$password = '';           // XAMPP varsayılan şifresi (genelde boştur)

try {
    // PDO ile güvenli bağlantı oluşturuyoruz
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Hata modunu aktif et (SQL hatalarını görmek için)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verileri varsayılan olarak ilişkisel dizi (array) şeklinde çek
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Bağlantı başarısız olursa hatayı ekrana bas ve durdur
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>
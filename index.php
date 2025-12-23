<?php
// Veritabanı bağlantısını dahil et
require 'db_baglan.php';

// Üniversiteleri çek
try {
    $stmt = $pdo->query("SELECT * FROM universiteler ORDER BY uni_id ASC LIMIT 3");
    $universiteler = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Veri çekme hatası: " . $e->getMessage());
}

// Arkaplan resimlerini (Henüz yüklemediğin için) manuel atıyorum.
// İleride veritabanına 'resim_url' sütunu ekleyip oradan çekebiliriz.
$bg_images = [
    1 => 'images/anadolu_uni.jpg', // Anadolu Üni için
    2 => 'images/esogu.jpg',       // ESOGÜ için
    3 => 'images/estu.jpg'         // ESTÜ için
];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üniversite Seçimi</title>
    <link rel="stylesheet" href="landing.css">
</head>
<body>

    <div class="container">
        <?php foreach ($universiteler as $uni): ?>
            <a href="clubs.php?uni_id=<?php echo $uni['uni_id']; ?>" class="split">
                
                <div class="bg-image" style="background-image: url('<?php echo $bg_images[$uni['uni_id']] ?? 'images/default.jpg'; ?>');"></div>
                
                <div class="overlay"></div>
                
                <div class="content">
                    <h1><?php echo htmlspecialchars($uni['kisaltma']); ?></h1>
                    <p><?php echo htmlspecialchars($uni['ad']); ?></p>
                    <div class="btn">Keşfet</div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

</body>
</html>
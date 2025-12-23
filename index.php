<?php
require 'db_baglan.php';

try {
    $stmt = $pdo->query("SELECT * FROM universiteler ORDER BY uni_id ASC LIMIT 3");
    $universiteler = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Veri çekme hatası: " . $e->getMessage());
}

$bg_images = [
    1 => 'images/anadolu_uni.jpg',
    2 => 'images/esogu.jpg',
    3 => 'images/estu.jpg'
];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üniversite Seçimi</title>
    
    <style>
        /* === GENEL AYARLAR === */
        body, html { margin: 0; padding: 0; width: 100%; height: 100%; overflow: hidden; font-family: 'Poppins', sans-serif; }
        .container { display: flex; width: 100%; height: 100%; }

        .split {
            flex: 1;
            position: relative;
            transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1); /* Daha akıcı animasyon */
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; overflow: hidden; color: white;
            cursor: pointer;
        }

        /* ARKAPLAN RESMİ (En Altta) */
        .bg-image {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-size: cover; background-position: center;
            transition: transform 0.8s ease;
            z-index: 1;
            filter: grayscale(30%); /* Resmi hafif gri yap ki renk daha iyi belli olsun */
        }

        /* RENKLİ PERDE (Resmin Üstünde) */
        .overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 2;
            
            /* İŞTE ÇÖZÜM BURADA: */
            /* Rengi HTML'den HEX olarak alacağız ama şeffaflığı buradan vereceğiz */
            opacity: 0.75; /* Başlangıçta %20 görünürlük */ 
            
            transition: opacity 0.6s ease, background-color 0.6s ease;
            /*mix-blend-mode: multiply; /* Rengi fotoğrafla daha iyi kaynaştırır (Opsiyonel) */
        }

        /* İÇERİK (En Üstte) */
        .content {
            position: relative; z-index: 3; text-align: center;
            transition: transform 0.5s ease;
            padding: 20px;
        }

        /* === HOVER EFEKTLERİ === */
        
        .split:hover { flex: 2.5; } /* Genişle */
        .split:hover .bg-image { 
            transform: scale(1.1); 
            filter: grayscale(0%); /* Resim canlansın */
        }

        /* Üzerine gelince perde şeffaflaşsın (Resim ortaya çıksın) */
        .split:hover .overlay {
            opacity: 0.1 !important; /* %10 görünürlük (neredeyse yok) */
        }

        /* Başlıklar */
        .content h1 {
            font-size: 2.5rem; margin-bottom: 10px; text-transform: uppercase;
            text-shadow: 0 4px 15px rgba(0,0,0,0.5);
            border-bottom: 2px solid rgba(255,255,255,0.7);
            padding-bottom: 10px; display: inline-block;
        }
        
        .content p { font-size: 1.2rem; text-shadow: 0 2px 5px rgba(0,0,0,0.8); margin-bottom: 20px;}

        /* Buton */
        .btn {
            border: 2px solid #fff; padding: 12px 35px; 
            display: inline-block; transition: all 0.3s;
            background: rgba(255,255,255,0.15);
            color: #fff; font-weight: bold; letter-spacing: 1px;
            text-transform: uppercase;
            backdrop-filter: blur(5px);
        }

        .split:hover .btn {
            background-color: #fff;
            color: #333; 
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

    <div class="container">
        <?php foreach ($universiteler as $uni): 
            // HEX KODUNU ALIYORUZ (Veritabanında #D35400 var)
            $renk = !empty($uni['ana_renk']) ? $uni['ana_renk'] : '#333';
        ?>
            
            <a href="clubs.php?uni_id=<?php echo $uni['uni_id']; ?>" class="split">
                
                <div class="bg-image" style="background-image: url('<?php echo $bg_images[$uni['uni_id']] ?? 'images/default.jpg'; ?>');"></div>
                
                <div class="overlay" style="background-color: <?php echo $renk; ?>;"></div>
                
                <div class="content">
                    <h1><?php echo htmlspecialchars($uni['kisaltma']); ?></h1>
                    <p><?php echo htmlspecialchars($uni['ad']); ?></p>
                    <div class="btn">Giriş Yap</div>
                </div>
            </a>

        <?php endforeach; ?>
    </div>

</body>
</html>
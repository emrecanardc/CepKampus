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
    <title>CepKampüs - Üniversite Seçimi</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        /* === GENEL AYARLAR === */
        body, html { margin: 0; padding: 0; width: 100%; height: 100%; overflow: hidden; font-family: 'Poppins', sans-serif; }
        .container { display: flex; width: 100%; height: 100%; }

        /* === YENİ EKLENEN MARKA KATMANI (Branding Layer) === */
        .branding-layer {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none; /* Tıklamalar arkaya geçer */
            z-index: 1000; /* En üstte durur */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 30px 40px;
            box-sizing: border-box;
        }

        /* Sol Üst Logo */
        .brand-logo {
            font-family: 'Montserrat', sans-serif; /* Logo için özel font */
            font-size: 1.8rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: 3px;
            text-transform: uppercase;
            text-shadow: 0 2px 10px rgba(0,0,0,0.8);
            display: flex; align-items: center;
        }
        
        .brand-logo::after {
            content: ''; display: block; width: 8px; height: 8px; 
            background: #fff; border-radius: 50%; margin-left: 8px;
            box-shadow: 0 0 10px rgba(255,255,255,0.8);
        }

        /* Sağ Alt İmza */
        .creator-credit {
            font-family: 'Montserrat', sans-serif;
            text-align: right;
            color: rgba(255,255,255,0.7);
            font-size: 0.85rem;
            font-weight: 400;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-shadow: 0 2px 5px rgba(0,0,0,0.9);
        }

        .creator-credit strong {
            color: #fff;
            font-weight: 700;
            margin-left: 5px;
            border-bottom: 2px solid rgba(255,255,255,0.3);
        }

        /* === MEVCUT TASARIM (AYNEN KORUNDU) === */
        .split {
            flex: 1;
            position: relative;
            transition: all 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; overflow: hidden; color: white;
            cursor: pointer;
        }

        .bg-image {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-size: cover; background-position: center;
            transition: transform 0.8s ease;
            z-index: 1;
            filter: grayscale(30%);
        }

        .overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 2;
            opacity: 0.75; 
            transition: opacity 0.6s ease, background-color 0.6s ease;
        }

        .content {
            position: relative; z-index: 3; text-align: center;
            transition: transform 0.5s ease;
            padding: 20px;
        }

        /* Hover Efektleri */
        .split:hover { flex: 2.5; }
        .split:hover .bg-image { transform: scale(1.1); filter: grayscale(0%); }
        .split:hover .overlay { opacity: 0.1 !important; }

        /* Başlıklar ve Buton */
        .content h1 {
            font-size: 2.5rem; margin-bottom: 10px; text-transform: uppercase;
            text-shadow: 0 4px 15px rgba(0,0,0,0.5);
            border-bottom: 2px solid rgba(255,255,255,0.7);
            padding-bottom: 10px; display: inline-block;
        }
        
        .content p { font-size: 1.2rem; text-shadow: 0 2px 5px rgba(0,0,0,0.8); margin-bottom: 20px;}

        .btn {
            border: 2px solid #fff; padding: 12px 35px; 
            display: inline-block; transition: all 0.3s;
            background: rgba(255,255,255,0.15);
            color: #fff; font-weight: bold; letter-spacing: 1px;
            text-transform: uppercase;
            backdrop-filter: blur(5px);
        }

        .split:hover .btn {
            background-color: #fff; color: #333; 
            transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

    <div class="branding-layer">
        <div class="brand-logo">CEPKAMPÜS</div>
        <div class="creator-credit">Project by <strong>Emre Can Ardıç</strong></div>
    </div>

    <div class="container">
        <?php foreach ($universiteler as $uni): 
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
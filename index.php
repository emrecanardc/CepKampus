<?php
// index.php dosyasında veritabanı bağlantısı yok, çünkü tema içinde zaten bağlanacak.

// Üniversiteleri çekip menüyü doldurmak için geçici olarak bağlanalım
include 'db_baglan.php'; 

$sql = "SELECT kisaltma, ad FROM universiteler ORDER BY kisaltma ASC";
$result = $baglanti->query($sql);

$page_title = "CepKampüs - Ana Sayfa";

// Bağlantıyı hemen kapatalım
$baglanti->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .initial-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            text-align: center;
            background-color: #f0f0f0;
        }
        .uni-selection-grid {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }
        .uni-link {
            text-decoration: none;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: bold;
            transition: transform 0.2s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .uni-link:hover {
            transform: translateY(-5px);
        }
        #anadolu { background-color: #b90000; }
        #esogu { background-color: #004a99; }
        #estu { background-color: #007f7a; }
    </style>
</head>
<body>
    <div class="initial-container">
        <h1>CepKampüs | Eskişehir Üniversite Kulüpleri Portalı</h1>
        <p class="lead">Lütfen kulüplerini incelemek istediğiniz üniversiteyi seçin:</p>
        
        <div class="uni-selection-grid">
            <?php 
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $uni_kisaltma = htmlspecialchars($row['kisaltma']);
                    $uni_ad = htmlspecialchars($row['ad']);
                    
                    echo '<a href="kulupler.php?uni=' . $uni_kisaltma . '" class="uni-link" id="' . strtolower($uni_kisaltma) . '">';
                    echo $uni_ad;
                    echo '</a>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
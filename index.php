<?php
// Veritabanı bağlantısı (Gerekirse ileride istatistik göstermek için kalsın)
include 'db_baglan.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CepKampüs - Üniversite Seçimi</title>
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
    
    <style>
        /* Sayfa Sıfırlama */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            overflow: hidden; /* Kaydırma çubuklarını gizle */
            font-family: 'Open Sans', sans-serif;
        }

        /* Ana Taşıyıcı: Ekranı Kaplar */
        .landing-container {
            display: flex; /* Yan yana dizilim */
            height: 100vh; /* Tam ekran yüksekliği */
            width: 100%;
        }

        /* Her Üniversite Sütunu */
        .uni-column {
            flex: 1; /* Hepsi eşit genişlikte başlar */
            background-size: cover;
            background-position: center;
            position: relative;
            transition: all 0.5s ease; /* Hover efekti için yumuşak geçiş */
            text-decoration: none;
            border-right: 4px solid #fff; /* Sütunlar arası çizgi */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .uni-column:last-child {
            border-right: none;
        }

        /* Üzerine gelince genişleme efekti */
        .uni-column:hover {
            flex: 1.5; /* Diğerlerinden daha geniş olur */
        }

        /* Siyah Perde (Yazının okunması için) */
        .overlay {
            background: rgba(0, 0, 0, 0.5); /* Yarı saydam siyah */
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            transition: background 0.3s;
        }

        .uni-column:hover .overlay {
            background: rgba(0, 0, 0, 0.2); /* Üzerine gelince aydınlan */
        }

        /* Üniversite İsimleri ve Buton */
        .content {
            position: relative;
            z-index: 2; /* Perdenin üzerinde olsun */
            text-align: center;
            color: white;
            padding: 20px;
        }

        .content h2 {
            font-size: 2em;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }

        .btn-git {
            display: inline-block;
            padding: 10px 30px;
            border: 2px solid white;
            color: white;
            text-transform: uppercase;
            font-weight: bold;
            transition: all 0.3s;
            background: rgba(0,0,0,0.3);
        }

        .uni-column:hover .btn-git {
            background: white;
            color: black;
        }

        /* Mobil Uyumluluk: Telefondan girilirse alt alta olsun */
        @media (max-width: 768px) {
            .landing-container {
                flex-direction: column; /* Alt alta diz */
            }
            .uni-column {
                border-right: none;
                border-bottom: 4px solid #fff;
            }
        }
    </style>
</head>
<body>

    <div class="landing-container">
        
        <a href="kulupler.php?uni=ANADOLU" class="uni-column" style="background-image: url('images/anadolu.jpg');">
            <div class="overlay"></div>
            <div class="content">
                <h2>Anadolu Üniversitesi</h2>
                <span class="btn-git">Kulüpleri İncele</span>
            </div>
        </a>

        <a href="kulupler.php?uni=ESOGU" class="uni-column" style="background-image: url('images/esogu.jpg');">
            <div class="overlay"></div>
            <div class="content">
                <h2>Osmangazi Üniversitesi</h2>
                <span class="btn-git">Kulüpleri İncele</span>
            </div>
        </a>

        <a href="kulupler.php?uni=ESTU" class="uni-column" style="background-image: url('images/estu.jpg');">
            <div class="overlay"></div>
            <div class="content">
                <h2>Teknik Üniversite</h2>
                <span class="btn-git">Kulüpleri İncele</span>
            </div>
        </a>

    </div>

</body>
</html>
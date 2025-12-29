<?php
// Hakkında sayfası
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Hakkında - CepKampüs</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body{font-family: 'Poppins',sans-serif;margin:0;padding:40px;background:#0f1720;color:#e6eef8}
        .wrap{max-width:900px;margin:0 auto}
        h1{margin-bottom:8px}
        p{line-height:1.6;color:#cbd5e1}
        .meta{margin-top:30px;font-size:0.9rem;opacity:0.85}
        a.btn{display:inline-block;margin-top:20px;padding:10px 16px;background:#fff;color:#0b1220;border-radius:8px;text-decoration:none;font-weight:600}
    </style>
</head>
<body>
    <div class="wrap">
        <h1>Hakkında</h1>
        <p>CepKampüs, üniversite ve kulüp bilgi ihtiyacını hızlı ve görsel olarak sunmak üzere tasarlanmış bir web projesidir. Kullanıcıların üniversiteleri keşfetmesini, ilgili kulüplerin detaylarına ulaşmasını ve etkinlikleri takip etmesini kolaylaştırmayı amaçlar. Proje; PHP, MySQL (PDO), ve modern ön yüz teknikleri kullanılarak geliştirilmiştir.</p>

        <p>Bu sayfa proje hakkında temel bilgiler içermektedir. İlerleyen safhalarda proje kapsamı, mimari ve kullanım kılavuzu buraya genişletilecektir.</p>

        <div class="meta">
            <div><strong>Geliştirici:</strong> Emre Can Ardıç</div>
            <div><strong>İletişim:</strong> emre@example.com (örnek)</div>
        </div>

        <a class="btn" href="index.php">Ana Sayfaya Dön</a>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

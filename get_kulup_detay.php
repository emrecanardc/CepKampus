<?php
require 'db_baglan.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['kulup_id'])) {
    echo json_encode(['error' => 'Kulüp ID eksik']);
    exit;
}

$kulup_id = (int)$_GET['kulup_id'];

try {
    // 1. Kulüp Bilgileri
    $stmt = $pdo->prepare("SELECT * FROM kulupler WHERE kulup_id = ?");
    $stmt->execute([$kulup_id]);
    $kulup = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Üyeler
    $stmt = $pdo->prepare("SELECT o.ad, o.soyad, ko.rol 
                           FROM kulup_ogrencileri ko 
                           JOIN ogrenciler o ON ko.ogrenci_id = o.ogrenci_id 
                           WHERE ko.kulup_id = ?
                           ORDER BY field(ko.rol, 'Baskan', 'Baskan Yardimcisi', 'Yonetim', 'Uye')");
    $stmt->execute([$kulup_id]);
    $uyeler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Etkinlikler (Hepsini Çekip PHP'de Ayıracağız)
    $stmt = $pdo->prepare("SELECT * FROM etkinlikler WHERE kulup_id = ? ORDER BY tarih_saat ASC");
    $stmt->execute([$kulup_id]);
    $tum_etkinlikler = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $gelecek_etkinlikler = [];
    $gecmis_etkinlikler = [];
    $su_an = date('Y-m-d H:i:s');

    foreach ($tum_etkinlikler as $etkinlik) {
        if ($etkinlik['tarih_saat'] >= $su_an) {
            $gelecek_etkinlikler[] = $etkinlik;
        } else {
            // Geçmiş etkinlikleri ters sıralayalım (en yeni geçmiş en üstte olsun)
            array_unshift($gecmis_etkinlikler, $etkinlik);
        }
    }

    // 4. Sponsorlar
    $stmt = $pdo->prepare("SELECT s.ad FROM kulup_sponsorluklari ks 
                           JOIN sponsorlar s ON ks.sponsor_id = s.sponsor_id 
                           WHERE ks.kulup_id = ?");
    $stmt->execute([$kulup_id]);
    $sponsorlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'kulup' => $kulup,
        'uyeler' => $uyeler,
        'etkinlikler' => [
            'gelecek' => $gelecek_etkinlikler,
            'gecmis' => $gecmis_etkinlikler
        ],
        'sponsorlar' => $sponsorlar
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Veritabanı hatası: ' . $e->getMessage()]);
}
?>
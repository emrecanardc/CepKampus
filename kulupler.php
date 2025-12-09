<?php
// 1. Veritabanı Bağlantısını hemen burada kuruyoruz (Hata çözüldü)
include dirname(__FILE__) . '/db_baglan.php'; 

// URL'den üniversite kısaltmasını güvenli bir şekilde al
$secilen_kisaltma = isset($_GET['uni']) ? $baglanti->real_escape_string($_GET['uni']) : '';

$universite_adi = "Tüm Kulüpler";
$kulup_sonuclari = null;
$uni_id = 0;
$uni_color = '#34495e'; 
$uni_image_url = '';

// PHP Haritalaması: Üniversite kısaltmasına göre rengi belirle
function get_uni_theme_color($kisaltma) {
    switch ($kisaltma) {
        case 'ANADOLU': return '#b90000'; 
        case 'ESOGU': return '#004a99';    
        case 'ESTU': return '#007f7a';     
        default: return '#34495e';
    }
}

if (!empty($secilen_kisaltma)) {
    
    // PHP Haritalaması ile rengi ve görseli çekiyoruz
    $uni_color = get_uni_theme_color($secilen_kisaltma);
    $uni_image_url = 'images/' . strtolower($secilen_kisaltma) . '.jpg';

    // Seçilen üniversitenin ID'sini ve adını bulma sorgusu
    $sql_uni = "SELECT uni_id, ad FROM universiteler WHERE kisaltma = '$secilen_kisaltma'";
    $result_uni = $baglanti->query($sql_uni);

    if ($result_uni && $result_uni->num_rows > 0) {
        $uni_data = $result_uni->fetch_assoc();
        $uni_id = $uni_data['uni_id'];
        $universite_adi = htmlspecialchars($uni_data['ad']);
        
        // O üniversiteye ait tüm kulüpleri çek
        $sql_kulupler = "SELECT kulup_id, ad, kisaltma, aciklama, kategori, ana_renk, ikincil_renk, ikon, kurulus_yili FROM kulupler WHERE uni_id = $uni_id";
        $kulup_sonuclari = $baglanti->query($sql_kulupler);
    }
}

// Header'a parametreleri gönderiyoruz
$active_uni = $secilen_kisaltma; 
$page_title = "Kulüpler Listesi";
// YENİ DÜZELTME: Güvenli include komutu
include dirname(__FILE__) . '/template/header.php'; 
?>

<div class="row">
    <div class="col-md-12">
        <h2 class="text-center text-primary" style="color: var(--uni-main-color) !important;"><?php echo $universite_adi; ?> Kulüpleri</h2>
        <hr>
    </div>
</div>

<div class="club-grid row">
    <?php
    if ($kulup_sonuclari && $kulup_sonuclari->num_rows > 0) {
        while ($kulup = $kulup_sonuclari->fetch_assoc()) {
            
            // Kurdele için kulüp adının ilk harfini alıyoruz
            $initial = strtoupper(substr($kulup['ad'], 0, 1));

            echo '<div class="col-md-4 col-sm-6 col-xs-12">';
            // KARTIN TAMAMI LİNK OLMALIDIR
            echo '<a href="kulup_detay.php?id=' . $kulup['kulup_id'] . '" ';
            echo 'class="club-card thumbnail" '; 
            echo 'data-initial="' . $initial . '" '; // Kurdele için ilk harf
            echo 'style="--club-color: ' . htmlspecialchars($kulup['ana_renk']) . '; --club-secondary-color: ' . htmlspecialchars($kulup['ikincil_renk']) . ';">';
            
            
            echo '    <div class="club-card-header">';
            echo '        <h3>' . htmlspecialchars($kulup['ad']) . '</h3>';
            echo '        <span>' . htmlspecialchars($kulup['kisaltma']) . ' | Kur: ' . htmlspecialchars($kulup['kurulus_yili']) . '</span>'; 
            echo '    </div>';
            
            echo '    <div class="club-card-body">';
            echo '        <p class="category">Kategori: ' . htmlspecialchars($kulup['kategori']) . '</p>';
            echo '        <p class="description">' . substr(htmlspecialchars($kulup['aciklama']), 0, 80) . '...</p>';
            echo '        <span class="card-link-text">Detayları Gör →</span>';
            echo '    </div>';

            echo '</a>';
            echo '</div>'; // /.col-md-4
        }
    } else {
        echo '<div class="col-md-12"><p class="alert alert-warning text-center">Bu üniversiteye ait aktif kulüp bulunmamaktadır.</p></div>';
    }
    ?>
</div>

<?php
// YENİ DÜZELTME: Güvenli include komutu
include dirname(__FILE__) . '/template/footer.php'; 
?>
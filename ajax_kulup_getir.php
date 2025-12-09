<?php
// Veritabanı bağlantısı
include 'db_baglan.php';

// ID kontrolü
$kulup_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($kulup_id > 0) {
    // 1. KULÜP DETAYLARINI ÇEK
    $sql_detay = "SELECT * FROM kulupler WHERE kulup_id = $kulup_id";
    $res_detay = $baglanti->query($sql_detay);

    if ($res_detay && $res_detay->num_rows > 0) {
        $k_detay = $res_detay->fetch_assoc();
        $ana_renk = !empty($k_detay['ana_renk']) ? $k_detay['ana_renk'] : '#34495e';
        ?>

        <div class="templatemo-content-widget white-bg">
            <div class="media">
                <div class="media-left">
                    <div style="width: 80px; height: 80px; background: <?php echo $ana_renk; ?>; color: #fff; font-size: 40px; text-align: center; line-height: 80px; border-radius: 50%;">
                        <?php echo strtoupper(substr($k_detay['ad'], 0, 1)); ?>
                    </div>
                </div>
                <div class="media-body">
                    <h2 class="media-heading text-uppercase"><?php echo htmlspecialchars($k_detay['ad']); ?></h2>
                    <span class="label label-primary" style="background-color: <?php echo $ana_renk; ?>"><?php echo htmlspecialchars($k_detay['kisaltma']); ?></span>
                    <span class="label label-info"><?php echo htmlspecialchars($k_detay['kategori']); ?></span>
                    <span class="label label-default">Kuruluş: <?php echo $k_detay['kurulus_yili']; ?></span>
                    <hr>
                    <p style="font-size: 15px; line-height: 1.6;">
                        <?php echo nl2br(htmlspecialchars($k_detay['aciklama'])); ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="panel panel-default templatemo-content-widget white-bg no-padding templatemo-overflow-hidden">
            <div class="panel-heading templatemo-position-relative" style="background-color: <?php echo $ana_renk; ?>;">
                <h2 class="text-uppercase" style="color: #fff;">Kulüp Üyeleri</h2>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>Öğrenci No</td>
                            <td>Ad Soyad</td>
                            <td>Rol</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql_uyeler = "
                            SELECT o.ad, o.soyad, o.ogrenci_no, ko.rol 
                            FROM kulup_ogrencileri ko
                            INNER JOIN ogrenciler o ON ko.ogrenci_id = o.ogrenci_id
                            WHERE ko.kulup_id = $kulup_id
                            ORDER BY ko.rol ASC, o.ad ASC";
                        
                        $res_uyeler = $baglanti->query($sql_uyeler);

                        if ($res_uyeler && $res_uyeler->num_rows > 0) {
                            while ($uye = $res_uyeler->fetch_assoc()) {
                                echo '<tr>';
                                // Sayaç kaldırıldı
                                echo '<td>' . htmlspecialchars($uye['ogrenci_no']) . '</td>';
                                echo '<td>' . htmlspecialchars($uye['ad'] . ' ' . $uye['soyad']) . '</td>';
                                
                                $badge_color = ($uye['rol'] == 'Başkan') ? '#d35400' : '#7f8c8d';
                                echo '<td><span class="badge" style="background-color: ' . $badge_color . ';">' . $uye['rol'] . '</span></td>';
                                
                                // Düzenle butonu kaldırıldı
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="3" class="text-center" style="padding: 10px;">Üye bulunamadı.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>    
            </div>                          
        </div>
        <?php
    }
}
?>
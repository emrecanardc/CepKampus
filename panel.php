<?php
include 'db_baglan.php';
include 'template/header.php';
?>

<div id="ana-icerik-alani">
    
    <div class="templatemo-content-widget white-bg text-center" style="padding: 50px;">
        <i class="fa fa-university fa-5x" style="color: #34495e; margin-bottom: 20px;"></i>
        <h2 class="text-uppercase margin-bottom-10">Yönetim Paneli</h2>
        <p class="margin-bottom-0" style="font-size: 18px;">
            Verilerini görmek istediğiniz kulübü <strong>sol menüden seçiniz.</strong><br>
            <small style="color: #999;">(Sayfa yenilenmeden veriler gelecektir)</small>
        </p>
    </div>

</div>

<?php include 'template/footer.php'; ?>

<script>
$(document).ready(function() {
    
    // Sol menüdeki ".kulup-link" sınıfına sahip linklere tıklanınca
    $(".kulup-link").click(function() {
        
        // 1. Tıklanan kulübün ID'sini al
        var kulupID = $(this).data("id");
        
        // 2. Aktif sınıfını güncelle (Tıklananı boya, diğerlerini söndür)
        $(".kulup-link").removeClass("active");
        $(this).addClass("active");
        
        // 3. Yükleniyor efekti ver
        $("#ana-icerik-alani").html('<div class="text-center" style="padding:50px;"><i class="fa fa-spinner fa-spin fa-3x"></i><p>Veriler Yükleniyor...</p></div>');
        
        // 4. AJAX İsteği Gönder
        $.ajax({
            url: "ajax_kulup_getir.php", // Arka planda gidecek dosya
            type: "GET",                 // Gönderim tipi
            data: { id: kulupID },       // Gönderilecek veri (?id=5 gibi)
            success: function(gelen_veri) {
                // 5. Gelen HTML kodlarını içeriğe bas
                $("#ana-icerik-alani").html(gelen_veri);
            },
            error: function() {
                $("#ana-icerik-alani").html('<div class="alert alert-danger">Bir hata oluştu!</div>');
            }
        });
    });

});
</script>
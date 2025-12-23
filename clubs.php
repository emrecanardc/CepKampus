<?php
require 'db_baglan.php';

$uni_id = isset($_GET['uni_id']) ? (int)$_GET['uni_id'] : 1;

// Üniversite rengini ve adını çek
$uni_sorgu = $pdo->prepare("SELECT ad, ana_renk FROM universiteler WHERE uni_id = ?");
$uni_sorgu->execute([$uni_id]);
$uni_bilgi = $uni_sorgu->fetch();

if (!$uni_bilgi) die("Hata: Üniversite bulunamadı!");

$header_renk = $uni_bilgi['ana_renk'] ?? '#111';

// Kulüpleri çek
$kulupler = [];
$kulup_sorgu = $pdo->prepare("SELECT * FROM kulupler WHERE uni_id = ?");
$kulup_sorgu->execute([$uni_id]);
$kulupler = $kulup_sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($uni_bilgi['ad']); ?> Kulüpleri</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="templatemo-3d-coverflow.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        body {
            transition: background-color 0.8s ease;
            background-color: #111; 
            color: #fff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0; padding: 0;
        }

        /* === HEADER === */
        .uni-header {
            position: fixed; top: 0; left: 0; right: 0; height: 70px;
            background-color: <?php echo $header_renk; ?>; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.4);
            display: flex; align-items: center; justify-content: center;
            z-index: 3000; border-bottom: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
        }
        .uni-header h1 {
            font-size: 1.2rem; margin: 0; text-transform: uppercase;
            letter-spacing: 1px; font-weight: 800;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3); text-align: center; max-width: 60%;
        }
        .back-btn {
            position: absolute; left: 20px; color: white; background: rgba(0,0,0,0.2); 
            padding: 8px 20px; border-radius: 30px; text-decoration: none;
            border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s ease;
            font-size: 0.9rem; font-weight: 500;
        }
        .back-btn:hover { background: rgba(255,255,255,0.2); transform: translateX(-3px); }
        .header-logo {
            position: absolute; right: 20px; font-family: 'Montserrat', sans-serif;
            font-weight: 900; font-size: 1.2rem; letter-spacing: 2px; color: #fff;
            text-transform: uppercase; display: flex; align-items: center; opacity: 0.9;
        }
        .header-logo::after {
            content: ''; display: block; width: 6px; height: 6px;
            background: #fff; border-radius: 50%; margin-left: 6px;
        }

        /* === SLIDER === */
        .info { top: 120px; } 
        #current-title { text-shadow: 0 4px 10px rgba(0,0,0,0.5); font-size: 3rem; margin-bottom: 5px; }
        #current-description { text-shadow: 0 2px 5px rgba(0,0,0,0.5); font-size: 1.2rem; margin-top: 5px; }
        #dynamic-details {
            max-width: 1200px; margin: 0 auto; padding: 40px 20px 100px 20px;
            opacity: 0; transform: translateY(20px); transition: all 0.5s ease;
        }
        #dynamic-details.visible { opacity: 1; transform: translateY(0); }

        .details-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
        .card-box {
            background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; padding: 30px; backdrop-filter: blur(10px); margin-bottom: 30px;
        }
        h3.section-title {
            font-size: 1.5rem; margin-bottom: 20px; padding-bottom: 10px;
            border-bottom: 2px solid rgba(255,255,255,0.2); color: #fff;
        }

        /* Etkinlik Kartları */
        .event-card {
            background: rgba(255,255,255,0.05); border-left: 4px solid #fff;
            padding: 15px; margin-bottom: 15px; border-radius: 0 10px 10px 0; transition: transform 0.2s;
        }
        .event-card:hover { transform: translateX(5px); background: rgba(255,255,255,0.08); }
        .event-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
        .event-name { font-weight: bold; font-size: 1.1rem; }
        .event-date { font-size: 0.85rem; opacity: 0.9; background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px;}
        .event-desc { font-size: 0.95rem; margin-bottom: 8px; opacity: 0.8; line-height: 1.4; }
        .event-meta { font-size: 0.85rem; opacity: 0.6; display: flex; gap: 15px; }
        .past-event { opacity: 0.5; filter: grayscale(0.8); } 

        .sponsor-grid { display: flex; gap: 15px; flex-wrap: wrap; }
        .sponsor-item { background: rgba(255,255,255,0.1); padding: 10px 15px; border-radius: 8px; font-weight: 500; font-size: 1rem; }
        .loading-text { text-align: center; font-size: 1.5rem; padding: 50px; opacity: 0.7; }

        /* === 2. DATATABLES CUSTOM CSS (DARK THEME) === */
        /* Tablo genel yazı rengi ve arkaplanı */
        table.dataTable tbody tr {
            background-color: transparent !important;
            color: #fff !important;
        }
        table.dataTable tbody tr:hover {
            background-color: rgba(255,255,255,0.1) !important;
        }
        /* Başlıklar */
        table.dataTable thead th {
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.3) !important;
        }
        /* Arama kutusu ve yazılar */
        .dataTables_wrapper .dataTables_length, 
        .dataTables_wrapper .dataTables_filter, 
        .dataTables_wrapper .dataTables_info, 
        .dataTables_wrapper .dataTables_processing, 
        .dataTables_wrapper .dataTables_paginate {
            color: #ccc !important;
        }
        /* Arama inputu */
        .dataTables_wrapper .dataTables_filter input {
            color: #fff;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 5px;
            padding: 5px;
        }
        /* Tablo alt çizgileri */
        table.dataTable td {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        /* Sayfalama Butonları */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #fff !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: rgba(255,255,255,0.2) !important;
            border-color: transparent !important;
            color: #fff !important;
        }

        @media(max-width: 768px) { .details-grid { grid-template-columns: 1fr; } .uni-header h1 { font-size: 0.9rem; } .header-logo { font-size: 0.9rem; } }
    </style>
</head>
<body>

    <div class="uni-header">
        <a href="index.php" class="back-btn">← Geri</a>
        <h1><?php echo htmlspecialchars($uni_bilgi['ad']); ?></h1>
        <div class="header-logo">CEPKAMPÜS</div>
    </div>

    <section id="home" class="section" style="min-height: 70vh;">
        <div class="coverflow-wrapper" style="height: auto; padding-top: 80px;">
            <div class="info">
                <h2 id="current-title">Yükleniyor...</h2>
                <p id="current-description">...</p>
            </div>

            <div class="coverflow-container" tabindex="0">
                <div class="coverflow" id="coverflow">
                    <?php 
                    $sayac = 0;
                    if (empty($kulupler)) { echo "<div style='color:white; text-align:center;'>Bu üniversitede henüz kulüp yok.</div>"; }
                    foreach ($kulupler as $kulup): 
                        $resim = !empty($kulup['resim_url']) ? $kulup['resim_url'] : 'images/default.jpg';
                    ?>
                        <div class="coverflow-item" data-index="<?php echo $sayac; ?>" data-id="<?php echo $kulup['kulup_id']; ?>">
                            <div class="cover"><img src="<?php echo htmlspecialchars($resim); ?>" alt="<?php echo htmlspecialchars($kulup['ad']); ?>"></div>
                            <div class="reflection"></div>
                        </div>
                    <?php $sayac++; endforeach; ?>
                </div>
                <button class="nav-button prev" onclick="navigate(-1)">‹</button>
                <button class="nav-button next" onclick="navigate(1)">›</button>
            </div>
        </div>
    </section>

    <div id="dynamic-details">
        <div class="loading-text">Kulüp bilgileri yükleniyor...</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        const items = document.querySelectorAll('.coverflow-item');
        const titleEl = document.getElementById('current-title');
        const descEl = document.getElementById('current-description');
        const detailsContainer = document.getElementById('dynamic-details');
        
        let currentIndex = Math.floor(items.length / 2);
        
        // Tabloyu hafızada tutmak için değişken (Destroy etmek için lazım)
        let membersTableInstance = null;

        function loadClubDetails(index) {
            if (!items[index]) return;

            const activeItem = items[index];
            const kulupId = activeItem.getAttribute('data-id');

            detailsContainer.style.opacity = '0.5';

            fetch('get_kulup_detay.php?kulup_id=' + kulupId)
                .then(res => res.json())
                .then(data => {
                    if (data.error) return;

                    const anaRenk = data.kulup.ana_renk || '#1a1a2e';
                    const ikinciRenk = data.kulup.ikincil_renk || '#667eea';

                    document.body.style.background = `radial-gradient(ellipse at center, ${anaRenk} 0%, #000000 100%)`;
                    titleEl.textContent = data.kulup.ad;
                    descEl.textContent = data.kulup.kisaltma || '';

                    // Etkinlikler (Gelecek & Geçmiş)
                    let gelecekHtml = data.etkinlikler.gelecek.length > 0 ? 
                        data.etkinlikler.gelecek.map(e => `
                            <div class="event-card" style="border-color:${ikinciRenk}">
                                <div class="event-header"><div class="event-name">${e.ad}</div><div class="event-date">📅 ${e.tarih_saat}</div></div>
                                <div class="event-desc">${e.aciklama || 'Açıklama yok.'}</div>
                                <div class="event-meta"><span>📍 ${e.konum}</span><span>👥 Tahmini: ${e.tahmini_katilimci} Kişi</span></div>
                            </div>`).join('') : '<p style="opacity:0.6">Yaklaşan etkinlik yok.</p>';

                    let gecmisHtml = data.etkinlikler.gecmis.length > 0 ? 
                        data.etkinlikler.gecmis.map(e => `
                            <div class="event-card past-event" style="border-color:#555">
                                <div class="event-header"><div class="event-name">${e.ad}</div><div class="event-date">🏁 ${e.tarih_saat}</div></div>
                                <div class="event-desc">${e.aciklama || 'Açıklama yok.'}</div>
                                <div class="event-meta"><span>📍 ${e.konum}</span><span>👥 Katılım: ${e.tahmini_katilimci} Kişi</span></div>
                            </div>`).join('') : '<p style="opacity:0.6">Geçmiş etkinlik yok.</p>';

                    // === 4. DATATABLE İÇİN HTML TABLO OLUŞTURMA ===
                    // Listeyi div yerine <table> olarak hazırlıyoruz
                    let membersHtml = `
                        <table id="membersTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Ad Soyad</th>
                                    <th>Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.uyeler.map(u => `
                                    <tr>
                                        <td>${u.ad} ${u.soyad}</td>
                                        <td>
                                            <span style="background:rgba(255,255,255,0.1); padding:2px 8px; border-radius:4px; font-size:0.9em;">
                                                ${u.rol}
                                            </span>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;

                    let html = `
                        <div class="details-grid">
                            <div class="left-col">
                                <div class="card-box">
                                    <h3 class="section-title" style="border-color:${ikinciRenk}; color:${ikinciRenk}">Hakkında</h3>
                                    <p>${data.kulup.aciklama || 'Açıklama bulunmuyor.'}</p>
                                    <p style="margin-top:10px; opacity:0.7;">Kategori: <strong>${data.kulup.kategori || 'Genel'}</strong></p>
                                </div>
                                <div class="card-box">
                                    <h3 class="section-title" style="border-color:${ikinciRenk}; color:${ikinciRenk}">🚀 Yaklaşan Etkinlikler</h3>
                                    ${gelecekHtml}
                                </div>
                                <div class="card-box">
                                    <h3 class="section-title" style="border-color:#888; color:#aaa">📜 Geçmiş Etkinlikler</h3>
                                    ${gecmisHtml}
                                </div>
                            </div>
                            <div class="right-col">
                                <div class="card-box">
                                    <h3 class="section-title" style="border-color:${ikinciRenk}; color:${ikinciRenk}">Yönetim & Üyeler</h3>
                                    <div id="membersContainer">${membersHtml}</div>
                                </div>

                                <div class="card-box">
                                    <h3 class="section-title" style="border-color:${ikinciRenk}; color:${ikinciRenk}">Sponsorlar</h3>
                                    <div class="sponsor-grid">
                                        ${data.sponsorlar.length > 0 ? data.sponsorlar.map(s => `<div class="sponsor-item">${s.ad}</div>`).join('') : '<p>Sponsor yok.</p>'}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    detailsContainer.innerHTML = html;
                    detailsContainer.style.opacity = '1';
                    detailsContainer.classList.add('visible');

                    // === 5. DATATABLE BAŞLATMA ===
                    // Eğer eski tablo varsa yok et (çakışmayı önler)
                    if ($.fn.DataTable.isDataTable('#membersTable')) {
                        $('#membersTable').DataTable().destroy();
                    }

                    // Yeni tabloyu başlat
                    $('#membersTable').DataTable({
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json" // Türkçe Dil Desteği
                        },
                        "pageLength": 5, // Sayfada 5 kişi göster
                        "lengthMenu": [5, 10, 20],
                        "ordering": false // Sıralamayı kapat (Başkan en üstte kalsın diye)
                    });
                })
                .catch(err => console.error("Veri çekme hatası:", err));
        }

        // Coverflow Fonksiyonları (Aynen korundu)
        function updateCoverflow() {
            items.forEach((item, index) => {
                let offset = index - currentIndex;
                const count = items.length;
                if (offset > count / 2) offset -= count;
                else if (offset < -count / 2) offset += count;
                const absOffset = Math.abs(offset);
                let translateX = offset * 220; 
                let translateZ = -absOffset * 200; 
                let rotateY = -(Math.sign(offset) * Math.min(absOffset * 60, 60)); 
                let opacity = 1 - (absOffset * 0.3); 
                let zIndex = 100 - absOffset;
                if (absOffset > 3) opacity = 0;
                item.style.transform = `translateX(${translateX}px) translateZ(${translateZ}px) rotateY(${rotateY}deg)`;
                item.style.opacity = opacity;
                item.style.zIndex = zIndex;
                if (index === currentIndex) item.classList.add('active'); else item.classList.remove('active');
            });
            loadClubDetails(currentIndex);
        }

        function navigate(direction) { currentIndex = (currentIndex + direction + items.length) % items.length; updateCoverflow(); }
        items.forEach((item, index) => { item.addEventListener('click', () => { currentIndex = index; updateCoverflow(); }); });
        document.addEventListener('keydown', (e) => { if (e.key === 'ArrowLeft') navigate(-1); if (e.key === 'ArrowRight') navigate(1); });
        updateCoverflow();
    </script>
</body>
</html>
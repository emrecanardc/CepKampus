<?php
require 'db_baglan.php';
$uni_id = isset($_GET['uni_id']) ? (int)$_GET['uni_id'] : 1;
$uni_sorgu = $pdo->prepare("SELECT ad, ana_renk FROM universiteler WHERE uni_id = ?");
$uni_sorgu->execute([$uni_id]);
$uni_bilgi = $uni_sorgu->fetch();
if (!$uni_bilgi) die("Hata: Üniversite bulunamadı!");
$header_renk = $uni_bilgi['ana_renk'] ?? '#111';
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

        
        .uni-header {
            position: fixed; top: 0; left: 0; right: 0; height: 70px;
            background: transparent;
            box-shadow: 0 6px 22px rgba(0,0,0,0.45);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 18px; box-sizing: border-box; position:relative;
            z-index: 3000; border-bottom: 1px solid rgba(255,255,255,0.04);
            backdrop-filter: blur(6px);
        }
        .uni-header .accent-bar{ position:absolute; left:0; right:0; top:0; height:6px; border-bottom-left-radius:6px; border-bottom-right-radius:6px; pointer-events:none }
        .uni-header .header-left,
        .uni-header .header-center,
        .uni-header .header-right { display:flex; align-items:center; gap:12px }
        .uni-header .header-left { min-width:160px }
        .uni-header .header-right { min-width:160px; justify-content:flex-end }
        .uni-header .header-center { flex:1; justify-content:center; text-align:center; flex-direction:column }
        .uni-name { color:#fff; font-size:1.35rem; font-weight:900; text-decoration:none; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:84%; letter-spacing:0.6px }
        .uni-name:hover { transform:scale(1.02); transition:transform 160ms ease }
        .uni-hint { font-size:0.78rem; opacity:0.9; color:rgba(255,255,255,0.92); margin-top:6px }
        .back-btn { color: white; background: rgba(0,0,0,0.18); padding:8px 14px; border-radius:22px; text-decoration:none; border:1px solid rgba(255,255,255,0.12); font-size:0.95rem; font-weight:600 }
        .back-btn:hover { background: rgba(255,255,255,0.08) }
        .brand-link { display:inline-flex; align-items:center; gap:10px; color:#fff; text-decoration:none }
        .brand-text { font-weight:900; text-transform:uppercase; letter-spacing:2px }
        .header-link { color:#fff; text-decoration:none; background: rgba(255,255,255,0.06); padding:8px 12px; border-radius:10px; font-weight:700 }
        .header-link:hover { background: rgba(255,255,255,0.12); }

        @media(max-width:700px) {
            .uni-name { font-size:1.05rem; max-width:60% }
            .uni-hint { display:none }
            .uni-header { padding: 0 10px }
        }
        .header-links { position: absolute; right: 140px; top: 0; height:70px; display:flex; align-items:center; gap:10px }
        .header-links a { color:#fff; text-decoration:none; background: rgba(255,255,255,0.06); padding:6px 10px; border-radius:8px; font-weight:600 }
        .header-links a:hover { background: rgba(255,255,255,0.12); }

        
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

        /* === SPONSOR ALANI === */
        .sponsor-grid { display: flex; gap: 20px; flex-wrap: wrap; align-items: center; justify-content: flex-start; }
        
        .sponsor-item {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            width: 100px; height: 100px;
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
            padding: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: #fff;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .sponsor-item:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            border-color: rgba(255,255,255,0.5);
        }
        
        .sponsor-logo {
            width: 100%; height: 100%;
            object-fit: contain;
            filter: grayscale(100%);
            transition: filter 0.3s;
        }
        .sponsor-item:hover .sponsor-logo {
            filter: grayscale(0%);
        }
        .sponsor-text-only { font-weight: bold; font-size: 0.9rem; text-align: center; }

        .loading-text { text-align: center; font-size: 1.5rem; padding: 50px; opacity: 0.7; }

        /* === DATATABLES CSS === */
        .dataTables_wrapper { color: #ddd !important; font-size: 0.9rem; padding-top: 10px; }
        .dataTables_wrapper .dataTables_filter { float: left; text-align: left; margin-bottom: 15px; width: 100%; }
        .dataTables_wrapper .dataTables_filter label { color: #fff !important; font-weight: 500; display: flex; align-items: center; gap: 10px; width: 100%; }
        .dataTables_wrapper .dataTables_filter input {
            background-color: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2) !important;
            color: #fff !important; border-radius: 8px; padding: 8px 12px; outline: none; width: 100%; max-width: 300px;
        }
        .bottom-wrapper { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; flex-wrap: wrap; gap: 10px; }
        .length-wrapper { text-align: center; margin-top: 15px; opacity: 0.5; font-size: 0.75rem; transition: opacity 0.3s; }
        .length-wrapper:hover { opacity: 1; }
        .dataTables_wrapper .dataTables_length label { color: #ccc !important; display: inline-flex; align-items: center; gap: 5px; justify-content: center; }
        .dataTables_wrapper .dataTables_length select {
            background-color: #222 !important; color: #fff !important; border: 1px solid rgba(255,255,255,0.2) !important; border-radius: 5px; padding: 2px 5px;
        }
        .dataTables_wrapper .dataTables_length select option { background-color: #222; color: #fff; }
        
        table.dataTable { width: 100% !important; border-collapse: separate !important; border-spacing: 0 5px; }
        table.dataTable tbody tr { background-color: rgba(255,255,255,0.05) !important; transition: background 0.3s; }
        table.dataTable tbody tr:hover { background-color: rgba(255,255,255,0.15) !important; }
        table.dataTable th, table.dataTable td { border-bottom: none !important; padding: 12px 10px !important; vertical-align: middle; }
        table.dataTable thead th { border-bottom: 2px solid rgba(255,255,255,0.2) !important; color: #aaa; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }

        .role-badge { background: rgba(255,255,255,0.15); padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; white-space: nowrap; display: inline-block; }
        .dataTables_wrapper .dataTables_paginate .paginate_button { color: #fff !important; border-radius: 5px !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: rgba(255,255,255,0.3) !important; border: none !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: rgba(255,255,255,0.5) !important; color: #000 !important; border: none !important; }

        @media(max-width: 768px) { 
            .details-grid { grid-template-columns: 1fr; } 
            .uni-header h1 { font-size: 0.9rem; } 
            .header-logo { font-size: 0.9rem; } 
            .dataTables_wrapper .dataTables_filter { float: none; text-align: left; }
            .dataTables_wrapper .dataTables_filter input { width: 100%; margin-left: 0; margin-top: 5px; }
        }
    </style>
</head>
<body>

    <div class="uni-header">
        <div class="accent-bar" style="background: <?php echo $header_renk; ?>; box-shadow: 0 8px 30px <?php echo $header_renk; ?>33"></div>
        <div class="header-left">
            <a href="index.php" class="brand-link" aria-label="Ana sayfa">
                <span class="brand-text">CepKampüs</span>
            </a>
        </div>

        <div class="header-center">
            <a href="index.php" class="uni-name"><?php echo htmlspecialchars($uni_bilgi['ad']); ?></a>
            <div class="uni-hint">Üniversite seçimine dönmek için üniversite adına tıklayın</div>
        </div>

        <div class="header-right">

            <a href="rapor.php" class="header-link">Rapor</a>
        </div>
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

        function ensureHex(v){ if(!v) return ''; v = String(v).trim(); if(v === '') return ''; return v.charAt(0) === '#' ? v : '#'+v; }

        function formatDateTime(dtStr){ try{ let d = new Date(dtStr); if(isNaN(d)) return dtStr||''; return d.toLocaleString(); } catch(e){ return dtStr||'' } }

        const iconMap = {
            film:'🎬', briefcase:'💼', plane:'✈️', heartbeat:'❤️', microchip:'💻', music:'🎵', 'hand-holding-heart':'🤝', 'shield-alt':'🛡️', database:'🗄️', gamepad:'🎮', palette:'🎨', bicycle:'🚲', flask:'⚗️', 'theater-masks':'🎭', utensils:'🍽️'
        };

        function loadClubDetails(index) {
            if (!items[index]) return;

            const activeItem = items[index];
            const kulupId = activeItem.getAttribute('data-id');

            detailsContainer.style.opacity = '0.5';

            fetch('get_kulup_detay.php?kulup_id=' + kulupId)
                .then(res => res.json())
                .then(data => {
                    if (data.error) return;

                    const anaRenk = ensureHex(data.kulup.ana_renk) || '#1a1a2e';
                    const ikinciRenk = ensureHex(data.kulup.ikincil_renk) || '#667eea';

                    // Logo / ikon fallback: tercih sırası -> resim_url (gerçek dosya) -> emoji ikon -> baş harf
                    let logoHtml = '';
                    const rawResim = data.kulup.resim_url || '';
                    const isDefaultImage = rawResim === '' || rawResim.indexOf('default.jpg') !== -1;
                    if(!isDefaultImage){
                        logoHtml = `<img src="${rawResim}" alt="${data.kulup.ad||''}" style="width:72px;height:72px;object-fit:cover;border-radius:12px;border:2px solid rgba(255,255,255,0.06)">`;
                    } else {
                        const ik = (data.kulup.ikon || '').toString();
                        const emoji = iconMap[ik] || null;
                        if(emoji){
                            logoHtml = `<div class=\"kulup-logo-emoji\">${emoji}</div>`;
                        } else {
                            const initial = (data.kulup.ad||'').charAt(0).toUpperCase() || '?';
                            logoHtml = `<div class=\"kulup-logo-initial\">${initial}</div>`;
                        }
                    }

                    document.body.style.background = `radial-gradient(ellipse at center, ${anaRenk} 0%, #000000 100%)`;
                    titleEl.textContent = data.kulup.ad;
                    descEl.textContent = data.kulup.kisaltma || '';

                    // Etkinlikler
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

                    // Üye Tablosu + Rol filtresi (öncelikle server'dan gelen tüm roller, yoksa üyelerden çıkar)
                    const roles = (data.all_roles && data.all_roles.length) ? data.all_roles : Array.from(new Set(data.uyeler.map(u => (u.rol||'').trim()).filter(r => r !== '')));
                    // Show up to 3 primary role buttons (design requirement)
                    const preferred = ['Baskan','Baskan Yardimcisi','Uye'];

                    // Short display labels for certain roles (display-only)
                    function displayRoleLabel(r){
                        if(!r) return '';
                        if(r === 'Baskan Yardimcisi') return 'BAŞKAN Y.';
                        if(r === 'Baskan') return 'BAŞKAN';
                        return r;
                    }
                    let buttonsList = [];
                    preferred.forEach(p=>{ if(roles.includes(p) && buttonsList.length<3) buttonsList.push(p); });
                    // fill remaining with other roles if less than 3
                    for(let i=0;i<roles.length && buttonsList.length<3;i++){ if(!buttonsList.includes(roles[i])) buttonsList.push(roles[i]); }

                    const roleButtons = buttonsList.map(r => `
                        <button type="button" class="role-btn" data-role="${r}" title="${r}">${displayRoleLabel(r)}</button>
                    `).join('');

                    let membersHtml = `
                        <div class="members-controls">
                            <div class="filter-pill" aria-label="Rol filtreleri">
                                <div class="role-chips-container">${roleButtons}</div>
                            </div>
                        </div>
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
                                        <td><span class="role-badge">${displayRoleLabel(u.rol)}</span></td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;

                    // === SPONSORLAR KODU (GÜNCELLENDİ: Link Düzeltmesi) ===
                    let sponsorsHtml = '';
                    if (data.sponsorlar.length > 0) {
                        data.sponsorlar.forEach(s => {
                            // Logo İşlemleri
                            let rawLogo = s.logo || s.resim_url || '';
                            let logoSrc = null;

                            if (rawLogo !== '') {
                                if (rawLogo.startsWith('images/')) {
                                    logoSrc = rawLogo;
                                } else {
                                    logoSrc = 'images/' + rawLogo;
                                }
                            }

                            // Link İşlemleri (HTTP Ekleme)
                            let rawLink = s.web_sitesi ? s.web_sitesi.trim() : '';
                            let webLink = '#';
                            let target = '';

                            if (rawLink !== '') {
                                target = 'target="_blank"'; // Link varsa yeni sekme aç
                                
                                // Başında http:// veya https:// yoksa ekle
                                if (!rawLink.startsWith('http://') && !rawLink.startsWith('https://')) {
                                    webLink = 'https://' + rawLink;
                                } else {
                                    webLink = rawLink;
                                }
                            }

                            sponsorsHtml += `
                                <a href="${webLink}" ${target} class="sponsor-item" title="${s.ad}">
                                    ${logoSrc ? 
                                        `<img src="${logoSrc}" class="sponsor-logo" alt="${s.ad}">` : 
                                        `<span class="sponsor-text-only">${s.ad}</span>`
                                    }
                                </a>
                            `;
                        });
                    } else {
                        sponsorsHtml = '<p>Sponsor yok.</p>';
                    }

                    let html = `
                        <style>
                            .kulup-logo-emoji, .kulup-logo-initial{width:72px;height:72px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:32px;color:#fff}
                            .kulup-logo-emoji{background:linear-gradient(135deg, ${anaRenk} 0%, ${ikinciRenk} 100%)}
                            .kulup-logo-initial{background:linear-gradient(135deg, ${anaRenk} 0%, ${ikinciRenk} 100%);font-weight:800}
                            .kulup-meta { font-size:0.9rem; color: rgba(255,255,255,0.9); }

                            /* Members role filter styling to match site (transparent pill + icon) */
                            .members-controls{ margin-bottom:12px }
                            .filter-pill{ display:flex; align-items:center; gap:8px; background:linear-gradient(90deg, rgba(255,255,255,0.03), rgba(255,255,255,0.015)); padding:8px 12px; border-radius:999px; border:1px solid rgba(255,255,255,0.04); backdrop-filter: blur(4px); width:100%; max-width:920px }
                            .role-chips-container{ display:flex; gap:8px; align-items:center; flex-wrap:nowrap; overflow-x:auto; -webkit-overflow-scrolling:touch; }
                            .role-chips-container::-webkit-scrollbar{ height:6px }
                            .role-chips-container::-webkit-scrollbar-thumb{ background: rgba(255,255,255,0.08); border-radius:4px }
                            .role-btn{ background: rgba(255,255,255,0.03); color:#e6eef8; border:1px solid rgba(255,255,255,0.04); padding:6px 10px; border-radius:999px; font-weight:700; font-size:0.9rem; cursor:pointer; min-width:72px; text-align:center; flex:0 0 auto; white-space:nowrap }
                            .role-btn.active{ background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03)); box-shadow: 0 6px 18px rgba(0,0,0,0.45) }
                            .role-btn:focus{ outline:none }
                            .role-chip.checked{ background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03)); box-shadow: 0 4px 18px rgba(0,0,0,0.45) }
                            .role-badge{background: rgba(255,255,255,0.06); padding:5px 8px; border-radius:999px; font-weight:700; font-size:0.85rem}
                            @media(max-width:700px){ .filter-label{display:none} .filter-pill{padding:6px 8px} .chip-label{font-size:0.78rem} .role-chips-container{max-width:100%;} }
                            @media(max-width:480px){ .role-btn{ min-width:48px; font-size:0.78rem; padding:5px 8px } }
                        </style>
                        <div class="details-grid">
                            <div class="left-col">
                                <div class="card-box">
                                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:10px">
                                        ${logoHtml}
                                        <div>
                                            <h3 class="section-title" style="margin:0; border:none; padding:0; color:${ikinciRenk}; font-size:1.15rem">${data.kulup.ad || ''}</h3>
                                            <div class="kulup-meta">${data.kulup.kategori ? data.kulup.kategori + ' · ' : ''}${data.kulup.kurulus_yili ? 'Kuruluş: ' + data.kulup.kurulus_yili : ''}</div>
                                            <div style="font-size:0.8rem;opacity:0.75;margin-top:6px">Sisteme eklenme: ${formatDateTime(data.kulup.olusturulma_tarihi)}</div>
                                        </div>
                                    </div>

                                    <p style="margin-top:8px">${data.kulup.aciklama || 'Açıklama bulunmuyor.'}</p>
                                    <p style="margin-top:10px; opacity:0.8;">Kategori: <strong>${data.kulup.kategori || 'Genel'}</strong></p>
                                </div>

                                <div class="card-box">
                                    <h3 class="section-title" style="border-color:${ikinciRenk}; color:${ikinciRenk}">Sponsorlar</h3>
                                    <div class="sponsor-grid">
                                        ${sponsorsHtml}
                                    </div>
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
                            </div>
                        </div>
                    `;

                    detailsContainer.innerHTML = html;
                    detailsContainer.style.opacity = '1';
                    detailsContainer.classList.add('visible');

                    // Datatable Kurulumu
                    if ($.fn.DataTable.isDataTable('#membersTable')) {
                        $('#membersTable').DataTable().destroy();
                    }

                    let membersTable = $('#membersTable').DataTable({
                        "language": {
                            "search": "Ara:",
                            "lengthMenu": "Sayfada _MENU_ kayıt göster",
                            "zeroRecords": "Eşleşen kayıt bulunamadı",
                            "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
                            "infoEmpty": "Kayıt yok",
                            "infoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
                            "paginate": {
                                "first": "İlk",
                                "last": "Son",
                                "next": "Sonraki",
                                "previous": "Önceki"
                            }
                        },
                        "pageLength": 5,
                        "lengthMenu": [5, 10, 20],
                        "ordering": false,
                        "autoWidth": false,
                        "dom": 'frt<"bottom-wrapper"ip><"length-wrapper"l>' 
                    });

                    // Rol filtresi - checkbox chips ile DataTable filtresi uygula
                    function applyRoleFilter(){
                        const active = Array.from(document.querySelectorAll('.role-btn.active')).map(b=>b.getAttribute('data-role'));
                        if(active.length === 0 || active.length === roles.length){
                            membersTable.column(1).search('').draw();
                            return;
                        }
                        const esc = active.map(v => $.fn.dataTable.util.escapeRegex(v));
                        const regex = '^(?:' + esc.join('|') + ')$';
                        membersTable.column(1).search(regex, true, false).draw();
                    }

                    // initialize role buttons and events
                    document.querySelectorAll('.role-btn').forEach(btn=>{
                        btn.classList.remove('active');
                        btn.addEventListener('click', ()=>{
                            // toggle active state
                            btn.classList.toggle('active');
                            applyRoleFilter();
                        });
                    });

                    // Move the members-controls under the DataTables search box for a cleaner layout
                    try{
                        const wrapperFilter = $('#membersTable_wrapper .dataTables_filter');
                        if(wrapperFilter.length){
                            wrapperFilter.css({'display':'flex','flex-direction':'column','align-items':'flex-start','gap':'8px'});
                            wrapperFilter.append($('.members-controls'));
                        }
                    } catch(e){ console.warn('Could not move members-controls:', e); }
                })
                .catch(err => console.error("Veri çekme hatası:", err));
        }

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
        <?php include 'footer.php'; ?>
</body>
</html>
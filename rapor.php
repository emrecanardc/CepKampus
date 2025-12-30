<?php
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proje Raporu - CepKampüs</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="landing.css">
    <link rel="stylesheet" href="templatemo-3d-coverflow.css">
    <style>
        html, body { width: 100%; min-height: 100vh; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; background: #0f1720; color: #e6eef8; overflow-x: hidden; }
        body { min-height: 100vh; padding-bottom: 92px; overflow-y: auto; }
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .report-title { text-align: center; margin-bottom: 0; }
        .report-title h1 { font-size: 2.1rem; font-weight: 900; margin-bottom: 8px; color: #fff; letter-spacing: 1px; }
        .report-title p { font-size: 1.05rem; color: #94a3b8; }
        .report-section {
            background: rgba(255,255,255,0.05);
            border-radius: 14px;
            padding: 28px 20px;
            margin: 0 auto;
            width: 100%;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .report-section h2 { font-size: 1.18rem; margin-bottom: 10px; color: #fff; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 6px; }
        .report-section h3 { font-size: 1.01rem; margin-top: 12px; margin-bottom: 6px; color: #cbd5e1; }
        .report-section p { color: #cbd5e1; margin-bottom: 8px; }
        .feature-list {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin: 10px 0;
            padding: 0;
        }
        .feature-list li {
            background: rgba(255,255,255,0.03);
            padding: 10px;
            border-radius: 7px;
            border-left: 3px solid #fff;
            font-size: 0.98rem;
        }
        .feature-list li:hover { background: rgba(255,255,255,0.08); border-left-color: #cbd5e1; }
        .db-table { overflow-x: auto; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; background: rgba(255,255,255,0.03); border-radius: 8px; overflow: hidden; }
        table th, table td { padding: 10px; text-align: left; border-bottom: 1px solid rgba(255,255,255,0.05); }
        table th { font-weight: 700; color: #fff; }
        table td { color: #cbd5e1; }
        table tbody tr:hover { background: rgba(255,255,255,0.05); }
        .highlight { color: #a8e6cf; font-weight: 600; }
        .back-btn { display: inline-block; margin-top: 18px; padding: 9px 18px; background: rgba(255,255,255,0.10); color: #fff; text-decoration: none; border-radius: 7px; border: 1px solid rgba(255,255,255,0.15); font-weight: 600; }
        .back-btn:hover { background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.3); }
        header { background: transparent; position: relative; z-index: 10; }
        .header-content { max-width: 1100px; margin: 0 auto; padding: 24px 20px 0 20px; display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; gap: 8px; font-size: 1.3rem; font-weight: 900; color: #fff; text-decoration: none; letter-spacing: 2px; }
        .logo-dot { width: 8px; height: 8px; background: #fff; border-radius: 50%; box-shadow: 0 0 10px rgba(255,255,255,0.8); }
        nav { display: flex; gap: 10px; }
        nav a { color: rgba(255,255,255,0.95); text-decoration: none; background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0.03)); padding: 7px 13px; border-radius: 8px; font-weight: 700; border: 1px solid rgba(255,255,255,0.04); font-size: 0.98rem; }
        nav a:hover, nav a.active { background: rgba(255,255,255,0.12); color: #fff; transition: all 160ms; }
        @media (max-width: 700px) {
            .container { padding: 10px 2vw; gap: 12px; }
            .header-content { flex-direction: column; align-items: flex-start; gap: 10px; padding: 12px 2vw 0 2vw; }
            .logo { font-size: 1.05rem; }
            .report-section { padding: 14px 6px; }
        }
    </style>
</head>
<body>
    
    <header>
        <div class="header-content">
            <a href="index.php" class="logo">
                <span>CepKampüs</span>
                <div class="logo-dot"></div>
            </a>
            <nav>
                <a href="index.php">Ana Sayfa</a>

                <a href="rapor.php" style="background: rgba(255, 255, 255, 0.12); color: #fff;">Rapor</a>
            </nav>
        </div>
    </header>

    
    <div class="container">
        <div class="report-title">
            <h1>📋 Proje Raporu</h1>
            <p>CepKampüs Web Uygulaması Teknik Belgeleri</p>
        </div>

        <!-- 1. Proje Amacı -->
        <div class="report-section">
            <h2>🎯 Proje Amacı</h2>
            <p>
                <span class="highlight">CepKampüs</span>, üniversite ve kampüs kulüp bilgilerini merkezi bir platform üzerinden
                sunmayı amaçlayan web tabanlı bir bilgi sistemidir. Proje aşağıdaki hedefleri gerçekleştirmek için tasarlanmıştır:
            </p>
            <ul class="feature-list">
                <li><strong>Üniversite Bilgisi:</strong> Türkiye'deki üniversitelerin merkezi veritabanı</li>
                <li><strong>Kulüp Yönetimi:</strong> Her üniversiteye ait kulüplerin detaylı bilgilerinin gösterilmesi</li>
                <li><strong>Etkinlik Takibi:</strong> Kulüplerin düzenledikleri etkinliklerin yayınlanması ve takibi</li>
                <li><strong>Kullanıcı Dostu Arayüz:</strong> Modern ve responsive tasarım ile erişebilirlik</li>
                <li><strong>Hızlı Erişim:</strong> Mobil cihazlardan kolay ve hızlı üniversite araması</li>
            </ul>

            <h3>Hedef Kitle</h3>
            <p>
                Lise öğrencileri, üniversite öğrencileri, veliler ve üniversite yöneticileri hedef kullanıcı gruplarını oluşturmaktadır.
                Proje özellikle üniversite seçim sürecinde adaylar ve ailelerine yardımcı olmayı amaçlamaktadır.
            </p>
        </div>

        <!-- 2. Kullanılan Teknolojiler -->
        <div class="report-section">
            <h2>💻 Kullanılan Teknolojiler</h2>
            <ul class="feature-list">
                <li><strong>PHP 7.4+</strong> - Sunucu tarafı komut dili</li>
                <li><strong>PDO (PHP Data Objects)</strong> - Veritabanı erişim sürücüsü</li>
                <li><strong>MySQL</strong> - İlişkisel veritabanı sistemi</li>
                <li><strong>HTML5</strong> - Web sayfası yapısı ve içerik</li>
                <li><strong>JavaScript</strong> - İnteraktif ve dinamik özellikler</li>
                <li><strong>jQuery</strong> - DOM manipülasyonu ve AJAX işlemleri</li>
                <li><strong>DataTables</strong> - Dinamik tablo oluşturma ve filtreleme</li>
                <li><strong>Google Fonts</strong> - Montserrat, Poppins tipografi</li>
                <li><strong>3D Coverflow CSS</strong> - Görsel sunuş efektleri</li>
            </ul>
        </div>


        <!-- 3. Veritabanı Yapısı -->
        <div class="report-section">
            <h2>🗄️ Veritabanı Yapısı</h2>

            <p>
                Proje <span class="highlight">universite_kulup_sistemi</span> adı altında MySQL veritabanını kullanmaktadır.
                Veritabanı aşağıdaki ana tablolardan oluşmaktadır:
            </p>

            <div style="text-align:center; margin: 24px 0;">
                <img src="images/veritabani_tasarim.png" alt="Veritabanı Tasarımı" style="max-width:100%;height:auto;border-radius:12px;box-shadow:0 2px 16px rgba(0,0,0,0.18);border:1px solid #222;">
                <div style="color:#cbd5e1; font-size:0.98rem; margin-top:8px;">Şekil: Üniversite Kulüp Sistemi Veritabanı Tasarımı</div>
            </div>

            <h3>1. Universiteler Tablosu</h3>
            <p>Türkiye'deki üniversitelerin bilgilerini içerir.</p>
            <div class="db-table">
                <table>
                    <thead>
                        <tr>
                            <th>Alan Adı</th>
                            <th>Veri Tipi</th>
                            <th>Açıklama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>uni_id</td>
                            <td>INT (Primary Key)</td>
                            <td>Üniversite benzersiz kimliği</td>
                        </tr>
                        <tr>
                            <td>ad</td>
                            <td>VARCHAR(255)</td>
                            <td>Üniversitenin adı</td>
                        </tr>
                        <tr>
                            <td>ana_renk</td>
                            <td>VARCHAR(7)</td>
                            <td>Üniversitenin kurumsal rengi (HEX)</td>
                        </tr>
                        <tr>
                            <td>sehir</td>
                            <td>VARCHAR(100)</td>
                            <td>Üniversitenin bulunduğu şehir</td>
                        </tr>
                        <tr>
                            <td>kurulis_yili</td>
                            <td>INT</td>
                            <td>Üniversitenin kurulış yılı</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3>2. Kulupler Tablosu</h3>
            <p>Her üniversiteye ait kulüplerin bilgilerini içerir.</p>
            <div class="db-table">
                <table>
                    <thead>
                        <tr>
                            <th>Alan Adı</th>
                            <th>Veri Tipi</th>
                            <th>Açıklama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>kulup_id</td>
                            <td>INT (Primary Key)</td>
                            <td>Kulüp benzersiz kimliği</td>
                        </tr>
                        <tr>
                            <td>uni_id</td>
                            <td>INT (Foreign Key)</td>
                            <td>İlgili üniversitenin kimliği</td>
                        </tr>
                        <tr>
                            <td>ad</td>
                            <td>VARCHAR(255)</td>
                            <td>Kulüp adı</td>
                        </tr>
                        <tr>
                            <td>aciklama</td>
                            <td>TEXT</td>
                            <td>Kulüp açıklama</td>
                        </tr>
                        <tr>
                            <td>olusturma_tarihi</td>
                            <td>DATE</td>
                            <td>Kulübün kurulduğu tarih</td>
                        </tr>
                        <tr>
                            <td>kategori</td>
                            <td>VARCHAR(50)</td>
                            <td>Kulüp kategorisi (Spor, Sanat, vb.)</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3>3. Etkinlikler Tablosu (İsteğe Bağlı)</h3>
            <p>Kulüplerin organize ettiği etkinlikleri içerir.</p>
            <div class="db-table">
                <table>
                    <thead>
                        <tr>
                            <th>Alan Adı</th>
                            <th>Veri Tipi</th>
                            <th>Açıklama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>etkinlik_id</td>
                            <td>INT (Primary Key)</td>
                            <td>Etkinlik benzersiz kimliği</td>
                        </tr>
                        <tr>
                            <td>kulup_id</td>
                            <td>INT (Foreign Key)</td>
                            <td>İlgili kulübün kimliği</td>
                        </tr>
                        <tr>
                            <td>baslik</td>
                            <td>VARCHAR(255)</td>
                            <td>Etkinlik başlığı</td>
                        </tr>
                        <tr>
                            <td>tarih</td>
                            <td>DATETIME</td>
                            <td>Etkinliğin tarihi ve saati</td>
                        </tr>
                        <tr>
                            <td>yer</td>
                            <td>VARCHAR(255)</td>
                            <td>Etkinliğin yapılacağı yer</td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>

        <!-- 4. Dosya Yapısı ve Modüller -->
        <div class="report-section">
            <h2>📁 Dosya Yapısı ve Modüller</h2>

            <h3>Ana Dosyalar</h3>
            <ul class="feature-list">
                <li><strong>index.php</strong> - Ana sayfa, üniversite seçim arayüzü</li>
                <li><strong>clubs.php</strong> - Seçilen üniversitedeki kulüpler listesi</li>

                <li><strong>rapor.php</strong> - Bu rapor sayfası</li>
            </ul>

            <h3>Yardımcı Dosyalar (Backend)</h3>
            <ul class="feature-list">
                <li><strong>db_baglan.php</strong> - Veritabanı bağlantı dosyası (PDO)</li>
                <li><strong>get_kulup_detay.php</strong> - AJAX ile kulüp detayları getiren modül</li>
                <li><strong>footer.php</strong> - Sayfanın alt kısmı (ıncluded)</li>
            </ul>

            <h3>Statik Dosyalar (Frontend)</h3>
            <ul class="feature-list">
                <li><strong>templatemo-3d-coverflow.css</strong> - 3D efekt stileri</li>
                <li><strong>templatemo-3d-coverflow-scripts.js</strong> - 3D animasyon kodları</li>
                <li><strong>landing.css</strong> - Genel stil dosyası</li>
                <li><strong>images/</strong> - Üniversite ve kulüp resimleri</li>
            </ul>

            <h3>Klasör Yapısı</h3>
            <div class="code-block">
cepkampus/
├── index.php
├── clubs.php

├── rapor.php
├── db_baglan.php
├── get_kulup_detay.php
├── footer.php
├── index.html
├── landing.css
├── templatemo-3d-coverflow.css
├── templatemo-3d-coverflow-scripts.js
├── images/
│   └── (üniversite ve kulüp resimleri)

            </div>
        </div>

        <!-- 5. Özellikler ve İşlevsellik -->
        <div class="report-section">
            <h2>⚙️ Sistem Özellikleri ve İşlevsellik</h2>

            <div class="grid-2">
                <div>
                    <h3>Dinamik Özellikler</h3>
                    <ul class="feature-list">
                        <li>Veritabanından dinamik veri çekme (PDO hazırlanmış sorgular)</li>
                        <li>AJAX ile asenkron veri yükleme</li>
                        <li>Real-time veri filtreleme ve arama</li>
                        <li>Responsive tasarım (mobil uyumlu)</li>
                        <li>Modern animasyonlar ve geçişler</li>
                    </ul>
                </div>
                <div>
                    <h3>Güvenlik Özellikleri</h3>
                    <ul class="feature-list">
                        <li>PDO parametreli sorgular (SQL Injection koruması)</li>
                        <li>htmlspecialchars() ile XSS koruması</li>
                        <li>Hata yönetimi ve istisna kontrolü</li>
                        <li>UTF-8 charset standardı</li>
                    </ul>
                </div>
            </div>
        </div>



        <!-- 7. Sonuç -->
        <div class="report-section">
            <h2>📝 Sonuç</h2>
            <p>
                <span class="highlight">CepKampüs</span> projesi, modern web teknolojileri kullanarak üniversite ve kampüs
                kulüp bilgisinin merkezi bir platformda sunulmasını sağlamaktadır. PHP backend ile MySQL veritabanı entegrasyonu,
                güvenli ve dinamik bir sistem oluşturmaktadır. Responsive tasarım sayesinde tüm cihazlardan erişilebilir olan
                uygulama, öğrenciler ve ailelerine değerli bir bilgi kaynağı sağlamaktadır.
            </p>
            <p>
                Proje, ileride kullanıcı yönetimi, admin paneli ve mobil uygulamalar gibi yeni özelliklerle genişletilmeye
                hazır bir mimariye sahiptir.
            </p>

            <h3>Geliştirici Bilgileri</h3>
            <div style="background: rgba(255, 255, 255, 0.05); padding: 20px; border-radius: 10px; margin-top: 20px;">
                <p><strong>Proje Adı:</strong> CepKampüs</p>
                <p><strong>Versiyon:</strong> 1.0</p>
                <p><strong>Oluşturma Tarihi:</strong> 2025</p>
                <p><strong>Son Güncelleme:</strong> 29 Aralık 2025</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="index.php" class="back-btn">← Ana Sayfaya Dön</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

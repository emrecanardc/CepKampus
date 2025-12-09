<?php
// PHP'de oturum yönetimini başlatmak iyi bir uygulamadır, ileride kullanırız.
// session_start(); 


// Dinamik Başlık
$page_title = isset($page_title) ? $page_title : "CepKampüs Yönetim Paneli"; 
$active_uni = isset($active_uni) ? $active_uni : ""; // Aktif üniversite kısaltması
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title; ?></title>

    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/css/templatemo-style.css" rel="stylesheet">
    <link href="template/css/font-awesome.min.css" rel="stylesheet">

    <link href="style.css" rel="stylesheet">

</head>
<body class="bg-dark">
    <div class="templatemo-content-wrapper">
        <div class="templatemo-sidebar">
            <div class="templatemo-sidebar-content">
                <div class="mobile-menu-icon">
                    <i class="fa fa-bars"></i>
                </div>
                <nav class="templatemo-nav">
                    <ul>
                        <li><a href="index.php"><i class="fa fa-home"></i>Ana Sayfa</a></li>
                        <li class="active"><a href="#"><i class="fa fa-university"></i>Üniversiteler</a></li>
                        
                        <?php
                        // Tüm üniversiteleri çekip menüye ekliyoruz
                        $sql_nav = "SELECT kisaltma, ad FROM universiteler ORDER BY kisaltma ASC";
                        $result_nav = $baglanti->query($sql_nav);
                        
                        if ($result_nav && $result_nav->num_rows > 0) {
                            while ($row_nav = $result_nav->fetch_assoc()) {
                                $nav_kisaltma = htmlspecialchars($row_nav['kisaltma']);
                                $nav_ad = htmlspecialchars($row_nav['ad']);
                                $is_active = ($nav_kisaltma == $active_uni) ? 'active' : '';

                                echo '<li class="' . $is_active . '">';
                                echo '    <a href="kulupler.php?uni=' . $nav_kisaltma . '">';
                                echo '        <i class="fa fa-dot-circle-o"></i> ' . $nav_kisaltma;
                                echo '    </a>';
                                echo '</li>';
                            }
                        }
                        ?>
                        </ul>
                </nav>          
            </div>
        </div>
        <div class="templatemo-content-container">
            <div class="templatemo-content">
                <div class="row">
                    <div class="col-md-12">
                        ```

### B. `template/footer.php` (Kapanış ve Scriptler)

Bu dosya, JavaScript dosyalarını yükler ve tüm açık HTML etiketlerini kapatır.

**Göreviniz:** `CepKampus/template/` klasörü içinde **`footer.php`** adında bir dosya oluşturun ve aşağıdaki kodu içine yapıştırın.

```php
                </div> </div> </div> </div> </div> <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center">&copy; 2025 CepKampüs Projesi | Template by templatemo</p>
                </div>
            </div>
        </div>
    </div>

    <script src="template/js/jquery.min.js"></script>
    <script src="template/js/bootstrap.min.js"></script>
    <script src="template/js/Chart.min.js"></script>
    <script src="template/js/templatemo_script.js"></script>
    
    <?php $baglanti->close(); ?>

</body>
</html>
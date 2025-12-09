<?php
// 1. URL'den üniversite bilgisini al
$secilen_uni = isset($_GET['uni']) ? htmlspecialchars($_GET['uni']) : '';
$secilen_kulup_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 2. Üniversite Resmini Belirle
$uni_resim_yolu = 'template/images/profile-photo.jpg'; 
if (!empty($secilen_uni)) {
    $uni_resim_yolu = 'images/' . strtolower($secilen_uni) . '.jpg';
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">  
    <title>CepKampüs - <?php echo $secilen_uni; ?></title>
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700" rel="stylesheet" type="text/css">
    <link href="template/css/font-awesome.min.css" rel="stylesheet">
    <link href="template/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/css/templatemo-style.css" rel="stylesheet">
    
    <style>
        .templatemo-left-nav li a.active {
            background-color: #18191b;
            border-left: 5px solid #13895F;
        }
        .profile-photo-container img {
            width: 100%;
            height: auto;
            border-bottom: 5px solid #13895F;
        }
        /* Yeni buton için stil */
        .btn-back-uni {
            margin: 15px 20px;
            display: block;
            text-align: center;
            background-color: #c0392b; /* Kırmızı ton */
            color: white;
            padding: 10px;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 13px;
            transition: all 0.3s;
        }
        .btn-back-uni:hover {
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>  
    <div class="templatemo-flex-row">
      
      <div class="templatemo-sidebar">
        <header class="templatemo-site-header">
          <div class="square"></div>
          <h1><?php echo $secilen_uni ? $secilen_uni : 'CepKampüs'; ?></h1>
        </header>
        
        <div class="profile-photo-container">
          <img src="<?php echo $uni_resim_yolu; ?>" alt="Üniversite Logosu" class="img-responsive">  
          <div class="profile-photo-overlay"></div>
        </div>      
        
        <form class="templatemo-search-form" role="search">
          <div class="input-group">
              <button type="submit" class="fa fa-search"></button>
              <input type="text" class="form-control" placeholder="Kulüp Ara..." name="srch-term" id="srch-term">           
          </div>
        </form>

        <a href="index.php" class="btn-back-uni">
            <i class="fa fa-arrow-left"></i> Üni. Seçimine Dön
        </a>

        <div class="mobile-menu-icon">
            <i class="fa fa-bars"></i>
        </div>

        <nav class="templatemo-left-nav">          
          <ul>
            <?php
            if (!empty($secilen_uni) && isset($baglanti)) {
                $sql_uni_id = "SELECT uni_id FROM universiteler WHERE kisaltma = '$secilen_uni'";
                $res_uni = $baglanti->query($sql_uni_id);

                if ($res_uni && $res_uni->num_rows > 0) {
                    $u_row = $res_uni->fetch_assoc();
                    $uni_id = $u_row['uni_id'];

                    $sql_kulupler = "SELECT kulup_id, ad FROM kulupler WHERE uni_id = $uni_id ORDER BY ad ASC";
                    $res_kulupler = $baglanti->query($sql_kulupler);

                    while ($kulup = $res_kulupler->fetch_assoc()) {
                        echo '<li>';
                        echo '<a href="javascript:void(0);" class="kulup-link" data-id="' . $kulup['kulup_id'] . '">';
                        echo '<i class="fa fa-users fa-fw"></i>' . htmlspecialchars($kulup['ad']);
                        echo '</a></li>';
                    }
                }
            } else {
                echo '<li><a href="#"><i class="fa fa-exclamation-circle"></i> Üniversite Seçilmedi</a></li>';
            }
            ?>
          </ul>  
        </nav>
      </div>
      
      <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-content-container">
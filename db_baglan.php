<?php
$baglanti = new mysqli("localhost","root","","universite_kulup_sistemi");
if ($baglanti->connect_error){
    die("CepKampüs Veritabanı Bağlantısı Başarısız:".$baglanti-> connect_error);
}
$baglanti->set_charset("utf8mb4");

?>
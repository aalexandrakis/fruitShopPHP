<?php
  header("Cache-Control: public");
header("Content-Description: File Transfer");
header('Content-Type: application/vnd.android.package-archive');
header("Content-Transfer-Encoding: binary");    
header('Content-Disposition: attachment; filename="Fruit-e-shop.apk"');
readfile('Fruit-e-shop.apk');
?>
<?php
    echo __DIR__;
    date_default_timezone_set('Europe/Athens');
      $date = date('Ymd');
      echo $date;
    echo "<form enctype=\"multipart/form-data\" method=\"POST\" action=\"tstdir.php\">";
 
    if (isset($_FILES['file'])){
	$aExtraInfo = getimagesize($_FILES['file']['tmp_name']);
    	$sImage = "data:" . $aExtraInfo["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['file']['tmp_name']));
        echo '<img src="', $sImage, '" alt="', $sImage, '">';
        echo $_FILES['file']['tmp_name'];
     } 
          echo "<input id=\"file\" type=\"file\" name=\"file\"> ";
     echo "<input type=\"submit\" name=\"submit\" name=\"submit\">";
      
?>
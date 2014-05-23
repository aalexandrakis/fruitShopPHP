	  <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php

  session_start();
  require("page.inc");
  $homepage=new Page();
  
  $fieldname = 'file'; 
   //$Path = "/home/vhosts/aalexandrakis.freevar.com/fruit-e-shop";
  /*$path= "C:/wamp/www/fruit-e-shop";*/
  $path=__DIR__;
  
  if (!isset($_SESSION['admin'])){
     die("Δεν έχεις πρόσβαση σε αυτή τη σελίδα");
  }
  
  if ((isset($_POST['submit'])) 
          and ($_FILES[$fieldname]['error'] == 0)
            and ($_FILES[$fieldname]['tmp_name'] != "")) {
       
       
     if ($_FILES[$fieldname]['type']!="image/gif" &&
         $_FILES[$fieldname]['type']!="image/jpeg" &&
         $_FILES[$fieldname]['type']!="image/jpg" &&
         $_FILES[$fieldname]['type']!="image/pjpeg" &&
         $_FILES[$fieldname]['type']!="image/x-png" &&
         $_FILES[$fieldname]['type']!="image/bmp" &&
         $_FILES[$fieldname]['type']!="image/png" ){
            //$error_message = "Λάθος τύπος αρχείου";
            die("Λάθος τύπος αρχείου");
            
         }  
     if(!is_uploaded_file($_FILES[$fieldname]['tmp_name'])){
        die("Δεν βρέθηκε αρχείο");
     }
     if (!getimagesize($_FILES[$fieldname]['tmp_name'])) {
        die("Δεν βρέθηκε αρχείο"); 
     }
     if ($_POST['type'] == "shop") {
       $path = $path."/images/";
     } else {
       $path = $path."/productimg/"; 
     }
     
     $date = new DateTime();
     $now = $date->getTimestamp();
     $uploadedfilename = $path.$_FILES[$fieldname]['name'];
     if (file_exists($uploadedfilename)){
       unlink($uploadedfilename);
     }
     if (move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadedfilename)) {
        echo "Η φωτογραφία ανέβηκε επιτυχώς στη διαδρομή ".$uploadedfilename;
     } else {  
        die("Προσπαθήστε αργότερα");
     }
  }
  
  $homepage->content = 
  "<form enctype=\"multipart/form-data\" method=\"POST\" action=\"photouploads.php\">
   
   <br>\n
    
      <span  style=\"margin-left:3px;font-weight: bold\">Ανεβάστε τις φωτογραφίες σας</span>
      <br>
      <input type=\"radio\" name=\"type\" value=\"shop\"> Φωτογραφίες καταστήματος<br>
      <input type=\"radio\" name=\"type\" value=\"product\" checked> Φωτογραφίες προιόντων<br>
      
      <label for=\"file\">Φωτογραφία:</label> 
      <input id=\"file\" type=\"file\" name=\"file\"> 
      <br> 
      <input id=\"submit\" type=\"submit\" name=\"submit\" value=\"Ανέβασμα φωτογραφίας\"> 
      <br>";  
	$homepage->Display();
?>

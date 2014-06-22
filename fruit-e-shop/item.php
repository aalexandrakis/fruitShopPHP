 <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  $error_message = "";
  $descr = "";
  $mm = "";
  $price = "";
  $categoryid = "";
  $display = "";
  $photo="";
 
  if (isset($_POST['descr'])){
     $descr = $_POST['descr'];}
  if (isset($_POST['mm'])){   
     $mm = $_POST['mm'];}
  if (isset($_POST['price'])){
     $price = $_POST['price'];}
  if (isset($_POST['categoryid'])){
     $categoryid = $_POST['categoryid'];}
  if (isset($_POST['display'])){
     $display = 1;} 
   else  {$display = 0;}
  if (isset($_POST['photo'])){
     $photo = $_POST['photo'];}
     else {$photo="";}
  
  
  if ((isset($_POST['descr'])) && ($_POST['descr'] == "")) {
  	   $error_message = "Δεν εχεις συμπληρώσει περιγραφή ";}
  else if ((isset($_POST['mm'])) && ($_POST['mm'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει μονάδα μέτρησης ";} 
  else if ((isset($_POST['price'])) && ($_POST['price'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει τιμή "; }
  else if ((isset($_POST['price'])) && (!is_numeric($_POST['price']))) {
       $error_message = "Η τιμή που έβαλες δεν είναι σωστή "; }
  else if ((isset($_POST['categoryid'])) && ($_POST['categoryid'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει κατηγορία "; }
  
  
  $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
  if (mysqli_connect_errno()) {
      die("Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.");
  }
  mysqli_autocommit($db, FALSE);
  $db->query("SET CHARACTER SET 'utf8'"); 
  

  if ((!isset($_POST['descr'])) and (isset($_GET['itemid']))) {
     
     $SelectQ = "select * from  items where itemid=".$_GET['itemid'];
          $result = $db->query($SelectQ);
          if (!$result->num_rows > 0 ) {
            die("Δεν βρέθηκε εγγρασφή με αυτό το είδος.");
            $db->close();
          } 
          $row = $result->fetch_assoc();
          $descr = $row['descr'];
          $mm = $row['mm'];
          $price = $row['price'];
          $categoryid = $row['categoryid'];
          $display = $row['display'];
          $photo = $row['photo'];
          $db->close();
     
  }
  
  
  $fieldname = 'file';
  //if (isset($_POST['btn'])){
  //   echo($_FILES[$fieldname]['tmp_name']);
  //   echo "<br>";
  //   echo($_FILES[$fieldname]['error']);
  //   die;
  //} 
  
  
  if ((isset($_POST['btn'])) 
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
            
     //die("into if");  
     if(!is_uploaded_file($_FILES[$fieldname]['tmp_name'])){
        //$error_message = "Δεν βρέθηκε αρχείο";
        die("Δεν βρέθηκε αρχείο");
     }
     //die("uploaded file");
     if (!getimagesize($_FILES[$fieldname]['tmp_name'])) {
        //$error_message = "Δεν βρέθηκε αρχείο";
        die("Δεν βρέθηκε αρχείο");
         
     }
     //die("image size");
     $path=__DIR__;
     $path = $path."/productimg/"; 
     
     
     $uploadedfilename = $path.$_FILES[$fieldname]['name'];
     
     if (file_exists($uploadedfilename)){
       unlink($uploadedfilename);
     }
     if (move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadedfilename)) {
        echo "Η φωτογραφία ανέβηκε επιτυχώς στη διαδρομή ".$uploadedfilename;
        $photo = $_FILES[$fieldname]['name'];
     } else {  
        die("Προσπαθήστε αργότερα");
     }
  }
  
  
        
  if ((isset($_POST['descr'])) and ($error_message == "") and (!isset($_GET['itemid'])) 
                               and (isset($_POST['btn']))) {
      date_default_timezone_set('Europe/Athens');
      $date = date('Ymd');
      
      $db->query("SET CHARACTER SET 'utf8'");
      $insertQ = "insert into items values(NULL, ".
                                           "'".$descr."', ".
                                           "'".$mm."', ".
                                           "'".$price."', ".
                                           "'".$categoryid."', ".
                                           "'".$display."', ".
                                           "'".$photo."', ".
                                           "'".$date."')";
      echo $insertQ;                                    
      $result=$db->query($insertQ);
      if(!$result){
        die("Η εγγραφή δεν μπόρεσε να ολοκληρωθεί. Παρακαλώ δοκιμάστε αργότερα.");
      }                                              
      $db->commit();
      mysqli_autocommit($db, TRUE);
      $db->close();
      $location = "Location: ".$homepage->path."/index.php";
      header($location);
  }
 
               
  if ((isset($_POST['descr'])) and ($error_message == "") and (isset($_GET['itemid']))
                               and (isset($_POST['btn']))) {
        
        date_default_timezone_set('Europe/Athens');
        $date = date('Ymd');
        $updateQ = "update items set ".
                           "descr='".$descr."', ".
                           "mm='".$mm."', ".
                           "price='".$price."', ".
                           "categoryid='".$categoryid."', ".
                           "display='".$display."', ".
                           "photo='".$photo."', ".
                           "lastUpdate='".$date."' ".
                           " where itemid = ".$_GET['itemid'];
         echo $updateQ;
         
         if (!$db->query("SET CHARACTER SET 'utf8'")){
            die("test character set");
         }
         $result = $db->query($updateQ);
         if (!$result) {
           die("Η ενημέρωση δεν μπόρεσε να ολοκληρωθεί. Παρακαλώ δοκιμάστε αργότερα."); 
         }
         $db->commit();
         mysqli_autocommit($db, TRUE);
         $db->close();
         $location = "Location: ".$homepage->path."/index.php?catid="
                   .$_POST['categoryid'];
         header($location);
  }   
    $idtextfield = "";
    if (isset($_GET['itemid'])) {
    $idtextfield = "<div class=\"form-group\">
             			<label for=\"itemid\" class=\"col-lg-2 control-label\">Κωδικός</label>
             			<div class=\"col-lg-10\">
                  			<input class=\"form-control\" id=\"itemid\" name=\"itemid\" placeholder=\"Κωδικός\" type=\"text\" value='".$_GET['itemid']."' readonly>
             		    </div>
    				</div>";
    }
    $homepage->content =            
    "<div class=\"container\">
  		<div class=\"bs-docs-section\">
  		<div class=\"row\">
          <div class=\"col-lg-8\">
            <div class=\"well bs-component\">
      <form class=\"form-horizontal\" enctype=\"multipart/form-data\" method=\"POST\" > \n
      <fieldset>";
    if (isset($error_message) && $error_message != ""){
    	$homepage -> content .=
    	"<div class=\"bs-component\"><div class=\"alert alert-dismissable alert-danger\">".$error_message."</div></div>\n";
    }	
    $homepage -> content .=
      $idtextfield."
       <div class=\"form-group\">
             <label for=\"descr\" class=\"col-lg-2 control-label\">Περιγραφή</label>
             <div class=\"col-lg-10\">
                  <input class=\"form-control\" id=\"descr\" name=\"descr\" placeholder=\"Περιγραφή\" type=\"text\" value='".$descr."'>
             </div>
       </div>
       <div class=\"form-group\">
             <label for=\"price\" class=\"col-lg-2 control-label\">Τιμή</label>
             <div class=\"col-lg-10\">
                  <input class=\"form-control\" id=\"price\" name=\"price\" placeholder=\"Τιμή\" type=\"text\" value='".$price."'>
       		 </div>
       </div>
       <div class=\"form-group\">
             <label for=\"mm\" class=\"col-lg-2 control-label\">Μονάδα Μέτρησης</label>
             <div class=\"col-lg-10\">
                 ".$homepage->BuiltComboMM($mm)." 
       		 </div>
       </div>
       <div class=\"form-group\">
             <label for=\"categoryid\" class=\"col-lg-2 control-label\">Κατηγορία</label>
             <div class=\"col-lg-10\">
                 ".$homepage->BuiltComboCat($categoryid)." 
       		 </div>
       </div>
       <div class=\"form-group\">
             <label for=\"display\" class=\"col-lg-2 control-label\">Εμφάνιση</label>
             <div class=\"col-lg-10\">
                 <input class=\"checkbox\" type=\"checkbox\" name=\"display\" value=".$display." ".$homepage->ischecked($display, 1)."> 
       		 </div>
       </div>
       <div class=\"form-group\">
             <label for=\"photo\" class=\"col-lg-2 control-label\">Φωτογραφία</label>
             <div class=\"col-lg-10\">
                 ".$homepage->BuiltComboPhotos($photo)." 
       		 </div>
       </div>
       <div class=\"form-group\">
          <label for=\"file\">Ανέβασε νέα φοτωγραφία</label>\n
          <div class=\"col-lg-10\"> 
          	<input class=\"btn btn-primary\" id=\"file\" type=\"file\" name=\"file\">\n
          </div>\n	
       </div>\n";
      
      if (isset($_GET['itemid'])) {
         $homepage->content=$homepage->content.
           "<div class=\"form-group\">
           		<div class=\"col-lg-2 col-lg-offset-2\">
         			<input class=\"btn btn-primary\" type=\"submit\" name=\"btn\" value=\"Διόρθωση\"> <br>\n
         		<div>
         	</div>";
      } else {
         $homepage->content=$homepage->content.
         "<div class=\"form-group\">
         	<div class=\"col-lg-2 col-lg-offset-2\">
	         <input class=\"btn btn-primary\" type=\"submit\" name=\"btn\" value=\"Εγγραφή\"> <br>\n
	      	<div>
         </div>";   
      } 
  $homepage->content .= "</fieldset></form></div></div></div></div></div>";   
   
  $homepage->Display();
?>
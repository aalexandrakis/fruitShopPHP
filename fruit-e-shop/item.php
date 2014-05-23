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
         $location = "Location: ".$homepage->path."/items.php?catid="
                   .$_POST['categoryid'];
         header($location);
  }   
    $idtextfield = "";
    if (isset($_GET['itemid'])) {
    $idtextfield = "<tr>   \n
                      <td> Κωδικός </td>\n
                      <td>".$_GET['itemid']."</td>\n
                    </tr>\n";
    }
    $homepage->content =            
    "
      <form enctype=\"multipart/form-data\" method=\"POST\" > \n
      <Table> \n".
        $idtextfield."
       <tr>\n
         <td> Περιγραφή </td>\n
         <td> <input type=\"text\" name=\"descr\" value='".$descr."' size=\"50\" ></td>\n
       </tr>\n
       <tr>\n
         <td> Τιμή </td>\n
         <td> <input type=\"text\" name=\"price\" value='".$price."'></td>\n
       </tr>\n
       <tr>\n
         <td> Μονάδα μέτρησης </td>\n
         <td>".$homepage->BuiltComboMM($mm)."</td>\n
       </tr>\n
       <tr>\n
         <td> Κατηγορία </td>\n
         <td>".$homepage->BuiltComboCat($categoryid)."</td>\n
       </tr>\n
       <tr>\n
         <td> Display </td>\n
         <td> <input type=\"checkbox\" name=\"display\" value=".$display." ".$homepage->ischecked($display, 1)."></td>\n
       </tr>\n
       <tr>\n
         <td> Φωτογραφία </td>\n
         <td>".$homepage->BuiltComboPhotos($photo)."</td>\n
       </tr>\n
       <tr>\n
          <td><label for=\"file\">Ανέβασε νέα φοτωγραφία</label></td>\n 
          <td><input id=\"file\" type=\"file\" name=\"file\"></td>\n
       </tr>\n   
      <br> 
      </table>";
      
      if (isset($_GET['itemid'])) {
         $homepage->content=$homepage->content.
           "<input type=\"submit\" name=\"btn\" value=\"Διόρθωση\"> <br>\n";
      } else {
         $homepage->content=$homepage->content.
           "<input type=\"submit\" name=\"btn\" value=\"Εγγραφή\"> <br>\n";
      } 
  $homepage->content=$homepage->content.   
   "<font color=\"red\">".$error_message."</font>\n"; 
   
   
   
   
	$homepage->Display();
?>
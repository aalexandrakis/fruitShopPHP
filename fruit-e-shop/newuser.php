  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  $homepage->SetJsFile="NewUser.js";
  $homepage->SetBodyOnKeyPress="OnKeyPressFunc(event)";
  $error_message = "";
  $name = "";
  $address = "";
  $city = "";
  $phone = "";
  $email = "";
  $password = "";
  $confpass = "";
   

  if (isset($_POST['name'])){
     $name = $_POST['name'];}
  if (isset($_POST['address'])){   
     $address = $_POST['address'];}
  if (isset($_POST['city'])){
     $city = $_POST['city'];}
  if (isset($_POST['phone'])){
     $phone = $_POST['phone'];}
  if (isset($_POST['email'])){
     $email = $_POST['email'];}
  if (isset($_POST['password'])){
     $password = $_POST['password'];}
  if (isset($_POST['confpass'])){
     $confpass = $_POST['confpass'];}
  
  //if ((isset($_POST['name'])) && ($_POST['name'] == "")) {
  //     $error_message = "Δεν εχεις συμπληρώσει Ονοματεπώνυμο ";}
  //else if ((isset($_POST['address'])) && ($_POST['address'] == "")) {
  //     $error_message = "Δεν εχεις συμπληρώσει Διευθυνση ";} 
  //else if ((isset($_POST['city'])) && ($_POST['city'] == "")) {
  //     $error_message = "Δεν εχεις συμπληρώσει Πόλη\Περιοχή "; }
  //else if ((isset($_POST['phone'])) && ($_POST['phone'] == "")) {
  //     $error_message = "Δεν εχεις συμπληρώσει Τηλέφωνο "; }
  //else if ((isset($_POST['email'])) && ($_POST['email'] == "")) {
  //     $error_message = "Δεν εχεις συμπληρώσει E-mail "; }
  //else if ((isset($_POST['password'])) && ($_POST['password'] == "")) {
  //     $error_message = "Δεν εχεις συμπληρώσει Κωδικό "; }
  //else if ((isset($_POST['confpass'])) && ($_POST['confpass'] == "")) {
  //     $error_message = "Δεν εχεις συμπληρώσει Επιβεβαίωση κωδικού "; }

  //if ((isset($_POST['password'])) && (isset($_POST['confpass'])) &&
  //        ($_POST['password'] != $_POST['confpass'])) {
  //        $error_message = "Η επιβεβαίωση κωδικού δεν είναι ίδια με τον κωδικό";}

  if(!filter_var( 'bob@example.com', FILTER_VALIDATE_EMAIL )){
        $error_message = "Λάθος Email";
  }
  if ((isset($_POST['name'])) and ($error_message == "")) {
     $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          $error_message = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
      } else {
          mysqli_autocommit($db, FALSE);
         $SelectQ = "select * from  customers where email=\"".$_POST['email']."\"";
          $result = $db->query($SelectQ);
          if ($result->num_rows > 0 ) {
            $error_message = "Υπάρχει ήδη εγγραφή με αυτό το e-mail.";
            $db->close();
          }
       
  }
 }
          
  if ((isset($_POST['name'])) and ($error_message == "")) {
  
      $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          $homepage->content = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
      } else {
        $date = date('Ymd');
        $db->query("SET CHARACTER SET 'utf8'");
        $insertQ = "Insert into customers values(NULL, \"".
                   $_POST['name']."\",\"".
                   $_POST['address']."\",\"".
                   $_POST['city']."\",\"".
                   $_POST['phone']."\",\"".
                   sha1($_POST['password'])."\",\"".
                   $_POST['email']."\",0, ".$date.")";
         $result = $db->query($insertQ);
         if (!$result) {
           $db->rollback();
           die("$insertQ"); 
         }
         $db->commit();
         mysqli_autocommit($db, TRUE);
         $db->close();
         //mail("aalexandrakis@hotmail.com", "Fruit shop Alexandrakis ", "New user ".$_POST['name'], 
         //                         "support@fsalexandrakis.gr");
         mail($homepage->GetAdminEmails(), $homepage->email_subject, "New user ".$_POST['name'], $homepage->email_headers);

         $homepage->content="Η εγγραφή σας ολοκληρώθηκε με επιτυχία.";
        }   
  } else {
  

  $homepage->content =            
  "
     <form action=\"newuser.php\" method=\"post\" name=\"NewUser\"> 
     
     <Table>
       <tr>
         <td> Ονοματεπώνυμο </td>
         <td> <input type=\"text\" name=\"name\" value='".$name."' size=\"50\" maxlength\"50\"></td>
       </tr>
       <tr>
         <td> Διεύθυνση </td>
         <td> <input type=\"text\" name=\"address\" value='".$address."' size=\"50\" maxlength\"100\"></td>
       </tr>
       <tr>
         <td> Πόλη/Περιοχή </td>
         <td> <input type=\"text\" name=\"city\" value='".$city."' size=\"50\" maxlength\"50\"></td>
       </tr>
       <tr>
         <td> Τηλέφωνο </td>
         <td> <input type=\"text\" name=\"phone\" value='".$phone."' size=\"10\" maxlength\"10\"></td>
       </tr>
       <tr>
         <td> E-mail </td>
         <td> <input type=\"text\" name=\"email\" value='".$email."' size=\"50\" maxlength\"50\"></td>
       </tr>
       <tr>
         <td> Κωδικός χρήστη </td>
         <td> <input type=\"password\" name=\"password\" value='".$password."' size=\"20\" maxlength\"20\"></td>
       </tr>                                             
       <tr>
         <td> Επιβεβαίωση κωδικού χρήστη </td>
         <td> <input type=\"password\" name=\"confpass\" value='".$confpass."' size=\"20\" maxlength\"20\"></td>
       </tr>
       </table>
     <input type=\"button\" value=\"Εγγραφή\" onClick=\"result=CheckNewUserData()\"> <br>
     <font color=\"red\">".$error_message."</font>";
    }
   
   
	$homepage->Display();
?>


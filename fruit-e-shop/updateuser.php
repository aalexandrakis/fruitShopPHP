  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  if ((isset($_SESSION['valid_user'])) && (!isset($_POST['name']))) {
      $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          $error_message = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
      } else {
         $db->query("SET CHARACTER SET 'utf8'");
         $SelectQ = "select * from  customers where email=\"".$_SESSION['valid_user']."\"";
          $result = $db->query($SelectQ);
          if ($result->num_rows > 0 ) {
            $row = mysqli_fetch_row($result);
            $name = $row[1];
            $address = $row[2];
            $city = $row[3];
            $phone = $row[4];
            $email = $row[6];
            $password ="";
            $confpass = "";  
            $db->close();
          } 
     
  }
  }
  $error_message = "";
  
  if (isset($_POST['name'])) {
      $name = $_POST['name'];
      $address = $_POST['address'];
      $city = $_POST['city'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $confpass = $_POST['confpass'];  
     }
     
  if ((isset($_POST['name'])) && ($_POST['name'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει Ονοματεπώνυμο ";}
  else if ((isset($_POST['address'])) && ($_POST['address'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει Διευθυνση ";} 
  else if ((isset($_POST['city'])) && ($_POST['city'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει Πόλη\Περιοχή "; }
  else if ((isset($_POST['phone'])) && ($_POST['phone'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει Τηλέφωνο "; }
  else if ((isset($_POST['email'])) && ($_POST['email'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει E-mail "; }
  else if ((isset($_POST['password'])) && ($_POST['password'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει Κωδικό "; }
  else if ((isset($_POST['confpass'])) && ($_POST['confpass'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει Επιβεβαίωση κωδικού "; }

  if ((isset($_POST['password'])) && (isset($_POST['confpass'])) &&
          ($_POST['password'] != $_POST['confpass'])) {
          $error_message = "Η επιβεβαίωση κωδικού δεν είναι ίδια με τον κωδικό";}

         
  if ((isset($_POST['name'])) && ($error_message == "")) {
      $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          $homepage->content = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
      } else {
         
        $db->query("SET CHARACTER SET 'utf8'");
        $updateQ = "Update customers set ".
                   "name = '".$_POST['name']."', ".
                   "address = '".$_POST['address']."', ".
                   "city = '".$_POST['city']."', ".
                   "phone = '".$_POST['phone']."', ".
                   "password = '".sha1($_POST['password'])."', ".
                   "email = \"".$_POST['email']."\" ".
                   "where email = '".$_SESSION['valid_user']."'";
         $result = $db->query($updateQ);
         $db->close();
             if (!$result) {
                $homepage->content="Η ενημέρωση δεν έγινε. Προσπαθήστε ξανά αργότερα."; 
              } else {
                $homepage->content="Τα στοιχεία σας διορθώθηκαν με επιτυχία.";
             }
        }   
  } else {
  

  $homepage->content =            
  "
     <form action=\"updateuser.php\" method=\"post\"> 
  
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
     <input type=\"submit\" value=\"Διόρθωση\"> <br>
     <font color=\"red\">".$error_message."</font>"; }
   
   
	$homepage->Display();
?>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  
  if (!isset($_SESSION['admin'])) {
     die("Δεν έχεις εξουσιοδότηση για αυτή τη σελίδα");
  }

  if ((isset($_SESSION['valid_user'])) && (isset($_GET['user_email'])) && (!isset($_POST['updateUser']))) {
      $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          $error_message = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
      } else {
         $db->query("SET CHARACTER SET 'utf8'");
         $SelectQ = "select * from  customers where email=\"".$_GET['user_email']."\"";
          $result = $db->query($SelectQ);
          if ($result->num_rows > 0 ) {
            $row = mysqli_fetch_row($result);
            $name = $row[1];
            $address = $row[2];
            $city = $row[3];
            $phone = $row[4];
            $email = $row[6];
            $isadmin = $row[7];
            $db->close();
          } 
     
     } 
  } else {
    
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
     
  

         
  if ((isset($_POST['name'])) && (isset($_POST['updateUser']))) {
      $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          $homepage->content = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
      } else {
        if (isset($_POST['isadmin'])) {
           $isadmin = 1;
        } else {
           $isadmin = 0;
        } 
        $db->query("SET CHARACTER SET 'utf8'");
        $updateQ = "Update customers set ".
                   "admin =".$isadmin." ".
                   "where email = '".$_GET['user_email']."'";
         echo $updateQ;
         $result = $db->query($updateQ);
         $db->close();
             if (!$result) {
                $homepage->content="Η ενημέρωση δεν έγινε. Προσπαθήστε ξανά αργότερα."; 
                } else {
                $homepage->content="Η αλλαγή ολοκληρώθηκε με επιτυχία.";
                $location = "Location: ViewCustomers.php";
                header($location);
             }
        }   
  } else {
  

  $homepage->content =            
  "
     <form  method=\"post\"> 
  
     <Table>
       <tr>
         <td> Ονοματεπώνυμο </td>
         <td> <input type=\"text\" name=\"name\" value='".$name."' size=\"50\" maxlength\"50\" readonly></td>
       </tr>
       <tr>
         <td> Διεύθυνση </td>
         <td> <input type=\"text\" name=\"address\" value='".$address."' size=\"50\" maxlength\"100\" readonly></td>
       </tr>
       <tr>
         <td> Πόλη/Περιοχή </td>
         <td> <input type=\"text\" name=\"city\" value='".$city."' size=\"50\" maxlength\"50\" readonly></td>
       </tr>
       <tr>
         <td> Τηλέφωνο </td>
         <td> <input type=\"text\" name=\"phone\" value='".$phone."' size=\"10\" maxlength\"10\" readonly></td>
       </tr>
       <tr>
         <td> E-mail </td>
         <td> <input type=\"text\" name=\"email\" value='".$email."' size=\"50\" maxlength\"50\" readonly></td>
       </tr>
       <tr>
         <td> Διαχειριστής Συστήματος </td>
         <td> <input type=\"checkbox\" name=\"isadmin\" value=".$isadmin." ".$homepage->ischecked($isadmin, 1)."/>\n 
       </table>
     <input type=\"submit\" name=\"updateUser\" value=\"Διόρθωση\"> <br>
     <font color=\"red\">".$error_message."</font>"; }
   
   
	$homepage->Display();
?>
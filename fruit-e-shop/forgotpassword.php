 <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $error_message="";
  $homepage->Set_Path();
  if ((isset($_POST['email'])) ) {
    $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          $error_message = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
      } else {
         $SelectQ = "select * from  customers where email=\"".$_POST['email']."\"";
          $result = $db->query($SelectQ);
          if ($result->num_rows <= 0 ) {
            $error_message = "Το email που δώσατε δεν βρέθηκε στη βάση δεδομένων. Προσπαθήστε ξανά.";
            $db->close();}
            else { 
              $newpass="";
              /*echo rand(1, 26); */
              for ($i=1;$i<7;$i=$i+1) {
                $newpass = $newpass.$homepage->Characters[rand(1,26)];
              }  
                $newpass = $newpass.rand(0,26);
                $db->query("SET CHARACTER SET 'utf8'");
                $UpdateQ = "update customers set password='".sha1($newpass)."' where email=\"".$_POST['email']."\"";
                $result = $db->query($UpdateQ);
                if (!$result) {
                   $error_message = "Δεν είναι δυνατή η αλλαγή του κωδικού. Προσπαθήστε αργότερα.";
                } else {
                  $msg = "Ο νέος σας κωδικός είναι ".$newpass;
                    mail($_POST['email'], $homepage->email_subject." αλλαγή κωδικού", $msg, 
                                  $homepage->email_headers);
                   
                }      
                   
                $db->close();
          }
      }
  }
  
  
  if ($_POST['email'] <> "") {
      $homepage->content = 
      " 
          <span> Ο νέος κωδικός σας εχει σταλεί στο email. </span>
          <br>
          <span> Μόλις συνδεθείτε αλάξτε τον κωδικό σας. </span>
          <br>";
  } else {
  $homepage->content = 
  "
    <form action=\"forgotpassword.php\" method=\"post\">
    
    <table border=(1px, solid, black)>
	  <tr>
	     <td class=\"headers\">E-mail </td>
	     <td> <input type=\"text\" name=\"email\" size=\"50\" maxlength=\"50\" /> </td>
	  </tr>
	  </table>	
	  <br>
	  <input type=\"submit\" name=\"submit\" Value=\"Ξέχασα τον κωδικό μου\" />
	  <br>
	  <font color=\"red\">".$error_message."</font>";
 }  
	$homepage->Display();
?>





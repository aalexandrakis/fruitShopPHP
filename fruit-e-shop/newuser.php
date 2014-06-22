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

  if($email != "" && !filter_var( $email, FILTER_VALIDATE_EMAIL )){
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
  
  	if ($error_message != ""){
  		$homepage->content .= "<div class=\"alert alert-danger\">".$error_message."</div>";
  	}
  	
  $homepage->content =            
  "  	<div class=\"bs-docs-section\">
  		<div class=\"row\">
          <div class=\"col-lg-8\">
            <div class=\"well bs-component\">";
            
  $homepage->content .= "<form class=\"form-horizontal\" action=\"newuser.php\" method=\"post\" name=\"NewUser\"> 
     				<fieldset>
     				 <div class=\"form-group\">
                    	<label for=\"name\" class=\"col-lg-2 control-label\">Όνομα</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"name\" name=\"name\" placeholder=\"Όνομα\" type=\"text\" value='".$name."'>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                    	<label for=\"address\" class=\"col-lg-2 control-label\">Διεύθυνση</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"address\" name=\"address\" placeholder=\"Διεύθυνση\" type=\"text\" value='".$address."'>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                    	<label for=\"city\" class=\"col-lg-2 control-label\">Πόλη</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"city\"  name=\"city\" placeholder=\"Πόλη\" type=\"text\" value='".$city."'>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                    	<label for=\"phone\" class=\"col-lg-2 control-label\">Τηλέφωνο</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"phone\" name=\"phone\" placeholder=\"Τηλέφωνο\" type=\"text\" value='".$phone."'>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                    	<label for=\"email\" class=\"col-lg-2 control-label\">E-mail</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"email\" name=\"email\" placeholder=\"E-mail\" type=\"text\" value='".$email."'>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                    	<label for=\"password\" class=\"col-lg-2 control-label\">Κωδικός</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"password\" name=\"password\" placeholder=\"Κωδικός\" type=\"password\" value='".$password."'>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                    	<label for=\"confpass\" class=\"col-lg-2 control-label\">Επιβεβαίωση κωδικού</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"confpass\" name=\"confpass\" type=\"password\" placeholder=\"Επιβεβαίωση κωδικού\"  value='".$confpass."'>
                      	</div>	
                    </div>
                    <div class=\"form-group\">
                      <div class=\"col-lg-2 col-lg-offset-2\">
			     		<input type=\"button\" class=\"btn btn-primary\"  value=\"Εγγραφή\" onClick=\"result=CheckNewUserData()\"> <br>
			          </div>
  					</div>
  					</fieldset>
                    </form>
                  	";
  	    
     $homepage->content .= "</div></div></div></div>";
  
    }
   
   
	$homepage->Display();
?>


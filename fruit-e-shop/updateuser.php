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
  "<div class=\"container\">
   <div class=\"bs-docs-section\">
  		<div class=\"row\">
  		<div class=\"col-lg-8\">
  		 <div class=\"well bs-component\">
  		 <form class =\"form-horizontal\" action=\"updateuser.php\" method=\"post\">";
  		  if (isset($error_message) && $error_message != ""){
  		  	$homepage -> content .=
              "<div class=\"alert alert-dismissable alert-danger\">".$error_message."</div>";
  		  }
          	$homepage -> content .=
            "<fieldset>
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
                      <div class=\"col-lg-10 col-lg-offset-2\">
			     		<input class=\"btn btn-primary\" type=\"submit\" value=\"Διόρθωση\"> <br>
			     	 </div>
			      </div>
			   </fieldset>
          		</form></div></div></div></div></div>";
  		}   	
     
   
   
	$homepage->Display();
?>
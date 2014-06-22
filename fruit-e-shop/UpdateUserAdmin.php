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
  "  <div class=\"container\">
   <div class=\"bs-docs-section\">
  		<div class=\"row\">
  		<div class=\"col-lg-8\">
  		 <div class=\"well bs-component\">";
  		 if (isset($error_message) && $error_message != ""){
  		 	$homepage -> content .=
  		 	"<div class=\"alert alert-dismissable alert-danger\">".$error_message."</div>";
  		 }
  		 
  		 $homepage -> content .=
  		 "<form class =\"form-horizontal\"  method=\"post\">
  		 <fieldset>
  		 <div class=\"form-group\">
                   	<label for=\"name\" class=\"col-lg-2 control-label\">Όνομα</label>
                   	<div class=\"col-lg-10\">
                   		<input class=\"form-control\" id=\"name\" name=\"name\" placeholder=\"Όνομα\" type=\"text\" value='".$name."' readonly>
                   	</div>
               	</div>
       			<div class=\"form-group\">
                    	<label for=\"address\" class=\"col-lg-2 control-label\">Διεύθυνση</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"address\" name=\"address\" placeholder=\"Διεύθυνση\" type=\"text\" value='".$address."' readonly>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                    	<label for=\"city\" class=\"col-lg-2 control-label\">Πόλη</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"city\"  name=\"city\" placeholder=\"Πόλη\" type=\"text\" value='".$city."' readonly>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                    	<label for=\"phone\" class=\"col-lg-2 control-label\">Τηλέφωνο</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"phone\" name=\"phone\" placeholder=\"Τηλέφωνο\" type=\"text\" value='".$phone."' readonly>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                    	<label for=\"email\" class=\"col-lg-2 control-label\">E-mail</label>
                    	<div class=\"col-lg-10\">
                      		<input class=\"form-control\" id=\"email\" name=\"email\" placeholder=\"E-mail\" type=\"text\" value='".$email."' readonly>
                    	</div>
                  	</div>
                  	<div class=\"form-group\">
                  	<div class=\"col-lg-10\">
	                  	<div class=\"checkbox\">
	                        <label>
	                          <input type=\"checkbox\" name=\"isadmin\" value=".$isadmin." ".$homepage->ischecked($isadmin, 1)."/> Διαχειριστής Συστήματος
	                        </label>
	                     </div>
                     </div>
                     </div>
     <input type=\"submit\" class=\"btn btn-warning\" name=\"updateUser\" value=\"Διόρθωση\"> <br>
     </fieldset>
     </form></div></div></div></div></div>"; 
  }
   
   
	$homepage->Display();
?>
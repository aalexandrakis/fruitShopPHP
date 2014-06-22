    <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  
  if (isset($_POST['yoursmail'])) {
      $yoursmail = $_POST['yoursmail'];
  }  else {
      $yoursmail = "";
  }
  
  if (isset($_POST['subject'])) {
      $subject = $_POST['subject'];
  }  else {
      $subject = "";
  }
  
  if (isset($_POST['mail'])) {
      $mail = $_POST['mail'];
  }  else {
      $mail = "";
  }
  $errormessage="";
  
  if (isset($_POST['yoursmail']) and $_POST['yoursmail']=="") {
      $errormessage = "E-mail is missing <br>";
  }
  if (isset($_POST['subject']) and $_POST['subject']=="") {
      $errormessage = $errormessage."Subject is missing <br>";
  }
   if (isset($_POST['mail']) and $_POST['mail']=="") {
      $errormessage = $errormessage."Main text is missing <br>";
  }
  
  $confirmation ="";
  if ($errormessage=="" and (isset($_POST['sendit']))) {
       mail($homepage->GetAdminEmails(), $subject, $mail, $yoursmail);
       $confirmation = "Your mail was sent succesfully. We are going to contact with you as soon as possible." ;
  }
  
  $homepage->content = 
  "
   <br>\n
     <div class=\"container\" >\n
    <div class=\"bs-docs-section\" >\n
    <div class=\"row\" >\n
    <div class=\"col-lg-6\" >\n 
    <div class=\"well bs-component\" >\n
   	 		<dl>
				<dt> email </dt>
					<dd> aalexandrakis@hotmail.com </dd>
  			<dt> Τηλέφωνα </dt>
					<dd> 210-7472461, 6948-211181 </dd>
			</dl>
   <form method=\"POST\" class=\"form-horizontal\" action=\"contactus.php\">
	  <fieldset>
	  	<legend>Στείλτε μας ένα μήνυμα  </legend>
     	<div class=\"form-group\">
             <label for=\"yoursmail\" class=\"col-lg-2 control-label\">Το email σας</label>
           	 <div class=\"col-lg-10\">
           		<input class=\"form-control\" id=\"yoursmail\" name=\"yoursmail\" placeholder=\"Το email σας\" type=\"text\" value='".$yoursmail."'>
             </div>
      	</div>		

      	<div class=\"form-group\">
             <label for=\"subject\" class=\"col-lg-2 control-label\">Θέμα</label>
           	 <div class=\"col-lg-10\">
           		<input class=\"form-control\" id=\"subject\" name=\"subject\" placeholder=\"Θέμα\" type=\"text\" value='".$subject."'>
             </div>
      	</div>		
        
      	<div class=\"form-group\">
             <label for=\"subject\" class=\"col-lg-2 control-label\">Κείμενο</label>
           	 <div class=\"col-lg-10\">
           		<textarea class=\"form-control\" id=\"mail\" name=\"mail\" placeholder=\"Κείμενο\" rows=\"3\" value='".$mail."'></textarea>
             </div>
      	</div>		
           
      </form>
      <br> 
      <input type=\"submit\" class=\"btn btn-primary\" name=\"sendit\" value=\"Αποστολή Email\">
      <br>
      <div class\"alert alert-dismissable alert-danger\">".$errormessage."</div> <br>
      </div></div></div></div></div>
      <div class\"alert alert-dismissable alert-success\">".$confirmation."</div><br>";
      
	$homepage->Display();
?>
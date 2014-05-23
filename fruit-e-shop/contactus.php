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
   <form method=\"POST\" action=\"contactus.php\">
   <br>\n
    <div class=\"contents\" width=\"100%\" >\n
   	 	<dl>
				<dt> email </dt>
					<dd> aalexandrakis@hotmail.com </dd>
  			<dt> Τηλέφωνα </dt>
					<dd> 210-7643761, 6948-211181 </dd>
			</dl>
    </div>
      <span  style=\"margin-left:3px;font-weight: bold\">Στείλτε μας ένα μήνυμα  </span>
      <table>
        <tr>
          <td> Your Email </td>
          <td> <input type=\"text\" name=\"yoursmail\" size=\"50\" value=\"".$yoursmail."\"> </td>
        </tr>
        <tr>
          <td> Mail Subject </td>
          <td> <input type=\"text\" name=\"subject\" size=\"50\" value=\"".$subject."\"> </td>
        </tr> 
        <tr>
          <td> Mail text</td>
          <td> <TEXTAREA NAME=\"mail\" ROWS=5 COLS=50>".$mail."</textarea> </td>
        </tr>
      </table>   
      <br> 
      <input type=\"submit\" name=\"sendit\" value=\"Αποστολή Email\">
      <br>
      <font color=\"red\">".$errormessage."  </font> <br>
      ".$confirmation."<br>";
      
	$homepage->Display();
?>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  $homepage->SetBodyOnKeyPress = "onBodyKeyPressed(event)";
  $homepage->SetJsFile = "Login.js";
 
  $error_message="";
                
  if (isset($_SESSION['admin'])){
     unset($_SESSION['admin']);
  }
  if ((isset($_POST['email'])) && (isset($_POST['password']))) {
    $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          $error_message = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
      } else {
         $SelectQ = "select * from  customers where email=\"".$_POST['email']."\" and password=\"".
         sha1($_POST['password'])."\"";
          $result = $db->query($SelectQ);
          if ($result->num_rows <= 0 ) {
            $error_message = "Το email ή ο κωδικός πρόσβασης είναι λάθος. Προσπαθήστε ξανά.";
            $db->close();}
            else { 
              $row = $result->fetch_assoc();
              
              if ($row['admin'] == 1){
                $_SESSION['admin']=1;
              }
              $_SESSION['valid_user'] = $_POST['email'];
              $db->close();
          }
      }
  }
  
  
  if (isset($_SESSION['valid_user'])) {
      $homepage->content = 
      " 
          <form action=\"logout.php\" method=\"post\">
          <span> Ευχαριστούμε που συνδεθήκατε στο κατάστημά μας </span>
          <br>";
  } else {
  $homepage->content = 
  "
    
    <form name=\"login\">
    <table border=(1px, solid, black)>
	  <tr>
	     <td class=\"headers\">E-mail </td>
	     <td> <input type=\"text\" name=\"email\" size=\"50\" maxlength=\"50\" /> </td>
	  </tr>
	  <tr>
	     <td class=\"headers\"> Κωδικός </td>
	     <td> <input type=\"password\" name=\"password\" size=\"20\" maxlength=\"20\" /> </td>
	  </tr>	
	  </table>	
	  <br>
	  <input type=\"button\" name=\"loginbtn\" Value=\"Εισοδος\" onClick=\"CheckLoginData()\"/>
    <input type=\"button\" name=\"forgotpassword\" Value=\"Ξέχασα τον κωδικό μου\" onClick=\"ForgotPasswordScript()\"/>
    <input type=\"button\" name=\"newuserbtn\" Value=\"Νέος χρήστης\" onClick=\"NewUserScript()\"/>
          <br>
	  

	  <font color=\"red\">".$error_message."</font>";
 }  
	$homepage->Display();
//<form name=\"login\" action=\"login.php\" method=\"post\">
//<a href=\"forgotpassword.php\">Ξέχασα τον κωδικό μου</a>
//<br>
//<a href=\"newuser.php\">Εγγραφή νέου χρήστη</a>
?>





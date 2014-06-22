  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  $error_message = "";
  $categoryid = "";
  $category = "";
  $message = "";
  
  $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
  if (mysqli_connect_errno()) {
      die("Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.");
  }
  mysqli_autocommit($db, FALSE);
  $db->query("SET CHARACTER SET 'utf8'");
  
  
  if (isset($_POST['category'])){
     $category = $_POST['category'];}
  
  if (isset($_GET['categoryid'])) {
      $SelectQ = "select * from  items_category where categoryid=\"".$_GET['categoryid']."\"";
      $result = $db->query($SelectQ);
      $row = $result->fetch_assoc();
      $category = $row['category'];
      $categoryid = $row['categoryid'];
  }
  
  if ((isset($_POST['category'])) && ($_POST['category'] == "")) {
       $error_message = "Δεν εχεις συμπληρώσει κατηγορία ";
       
  } else if ((isset($_POST['category'])) and ($_POST['category'] !== "")) {
     $SelectQ = "select * from  items_category where category=\"".$_POST['category']."\"";
     $result = $db->query($SelectQ);
     
     if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['categoryid'] !== $categoryid) {
           $error_message = "Υπάρχει ήδη αυτή η κατηγορία.";
           $db->close();
        }   
     }
     
  } 
  
  if (($error_message =="") and (isset($_POST['category'])) and (isset($_POST['btn']))) {  
     if (isset($_GET['categoryid'])){
        $Query = "update items_category set category = '".$_POST['category'].
                 "' where categoryid=".$_GET['categoryid'];
        $message = "Η διόρθωση ολοκληρώθηκε επιτυχώς";         
     } else {
        $Query = "insert into items_category values(NULL, '".$_POST['category']."')";
        $message = "Η προσθήκη ολοκληρώθηκε επιτυχώς";
     }
                                          
     $result = $db->query($Query);
     if (!$result){
       echo $Query;
       die("Η συναλλαγή δεν μπορεί να γίνει αυτή τη στιγμή.Προσπαθήστε αργότερα");
       $db->close();
     } else {
       $db->commit();
       mysqli_autocommit($db, TRUE);
       $db->close();
       $homepage->content =$message;
       header("Location: ".$homepage->path."/categories.php");
     }
       
  }  else {
  
  /*if ($error_message !==""); {*/
 
    $idtextbox = "";
    $buttonvalue = "Νέα εγγραφή"; 
    if (isset($_GET['categoryid'])){
        $idtextbox = "
       	<div class=\"form-group\">
             <label for=\"categoryid\" class=\"col-lg-2 control-label\">Κωδικός</label>
             <div class=\"col-lg-10\">
                  <input class=\"form-control\" id=\"categoryid\" name=\"categoryid\" placeholder=\"Κωδικός\" type=\"text\" value='".$_GET['categoryid']."' readonly>
             </div>
         </div>";
        $buttonvalue = "Διόρθωση";
    
    }
    $homepage->content =            
    "
    <div class=\"bs-docs-section\">
  		<div class=\"row\">
          <div class=\"col-lg-8\">
            <div class=\"well bs-component\">
     <form class=\"form-horizontal\" method=\"post\">\n";
      if (isset($error_message) && $error_message != ""){
      	$homepage -> content .=
          "<div class=\"alert alert-dismissable alert-danger\">".$error_message."</div>\n";
      }
     $homepage -> content .=
     "<fieldset>
     <Table>".
       $idtextbox.
     	"<div class=\"form-group\">
             <label for=\"category\" class=\"col-lg-2 control-label\">Κατηγορία</label>
             <div class=\"col-lg-10\">
                  <input class=\"form-control\" id=\"category\" name=\"category\" placeholder=\"Κατηγορία\" type=\"text\" value='".$category."'>
             </div>
         </div>
         <div class=\"form-group\">
           <div class=\"col-lg-2 col-lg-offset-2\">
     			<input type=\"submit\" class=\"btn btn-primary\" name=\"btn\" value=\"".$buttonvalue."\"> <br> \n
     	   </div>
     	</div>   		
     </form></div></div></div></div>";
      
  }
   
   
	$homepage->Display();
?>
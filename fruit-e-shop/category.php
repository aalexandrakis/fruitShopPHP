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
        $idtextbox = "<tr>\n
                        <td> Κωδικός </td>
                        <td>".$_GET['categoryid']."</td>\n
                      </tr>\n";
        $buttonvalue = "Διόρθωση";
    
    }
    $homepage->content =            
    "
     <form method=\"post\">\n 
  
     <Table>".
       $idtextbox.
       "<tr>\n
         <td> Κατηγορία </td>\n
         <td> <input type=\"text\" name=\"category\" value='".$category."' size=\"50\" maxlength\"50\"></td>\n
       </tr>\n
     </table> \n
     <input type=\"submit\" name=\"btn\" value=\"".$buttonvalue."\"> <br> \n
     <font color=\"red\">".$error_message."</font>\n"; 
  }
   
   
	$homepage->Display();
?>
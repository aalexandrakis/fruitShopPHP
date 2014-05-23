    <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php 
  session_start();
  include ('page.inc');
  $homepage=new Page();
  $homepage->Set_Path();
  
  $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          echo "Η συνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ δοκιμάστε αργότερα.";
          exit;
      } else {
         $selectQ = "select * from  items_category order by category";
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($selectQ);
         
      }    
  /*if  (!isset($_SESSION['valid_user'])) {
   $homepage->content = "Πρέπει να συνδεθείς για να κάνεις παραγγελεία.";
  } else {*/
            
  $homepage->content = 
            $homepage->content.
 "
  
  <br>\n
  <h3>Δημιουργια παραγγελιας</h3>\n 
  <br>";                 
  
    while ($row = mysqli_fetch_assoc($result)) {
         $homepage->content =  $homepage->content.
         "<a href=items.php?catid=".$row['categoryid'].">".$row['category']."</a><br>"; 
    }
    
 $db->close();   
  
      
 /*}*/ 
   
   

  
  $homepage->Display();  
  
  
?>

   
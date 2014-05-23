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
  $header = "Δημιουργία παραγγελίας";    
  if  (isset($_SESSION['admin'])) {
      $header = "Επεξεργασία κατηγοριών";
  }            
  if  (!isset($_SESSION['valid_user'])) {
   $homepage->content = "Πρέπει να συνδεθείς για να κάνεις παραγγελεία.";
  } else {
            
  $homepage->content = 
            $homepage->content.
 "<form method=\"post\"/>\n
  
  
  <br>\n
  <h3>".$header."</h3>\n 
  <br>";                 
  
    while ($row = mysqli_fetch_assoc($result)) {
         $homepage->content =  $homepage->content.
         "<a href=category.php?categoryid=".$row['categoryid'].">".$row['category']."</a><br>\n"; 
    }
    
 $db->close();   
 if (isset($_SESSION['admin'])){
    $homepage->content =  $homepage->content.
        "<button  name=\"addnew\" onclick=\"this.form.action='category.php';\n
                                            this.form.submit()\">\n
              Προσθήκη νέας κατηγορίας\n
         </button>";                                     
 }
  
      
 } 
   
   

  
  $homepage->Display();  
  
  
?>

   
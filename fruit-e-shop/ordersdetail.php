    <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php 
  session_start();
  include ('page.inc');
  $homepage=new Page();
  $homepage->Set_Path();
  if ((!isset($_SESSION['admin'])) and (!isset($_SESSION['valid_user']))) {
      die("Δεν έχεις εξουσιοδότηση να δεις αυτή τη σελίδα.");
  }
  
   $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          die("Η συνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ δοκιμάστε αργότερα.");
      } 
   
   $selectQ = "select * from  orders where orderid = ".$_GET['orderid'];
   $db->query("SET CHARACTER SET 'utf8'");
   $result = $db->query($selectQ);
   if (!$result) {
      die("Δεν υπάρχει παραγγελία με αυτό το νούμερο".$_GET['orderid']); 
   }
   $row=$result->fetch_assoc();
   $status = $row['status'];
   if (isset($_POST['UpdateStatus'])){
     $updateQ = "update orders set status = ".($row['status'] + 1).
                    " where orderid=".$_GET['orderid'];
     $result = $db->query($updateQ);
     if (!$result) {
        echo $updateQ;
        die("<br> Δεν μπορεί να γίνει ενημέρωση αυτή τη στιγμή");
     } else {
       $db->commit();
       $status = $row['status'] + 1 ;
       /*echo $updateQ;   */
     }
   } 
  
   
   $header = "Παραγελία Νο:".$_GET['orderid']."<br> Κατάσταση παραγγελίας:".$homepage->Order_Status[$row['status']];
   
   $selectQ = "select * from  ordered_items inner join items using(itemid) ".
                 "where orderid = ".$_GET['orderid'];
                 
   $db->query("SET CHARACTER SET 'utf8'");
   $result = $db->query($selectQ);
       /*<form method=\"GET\" action=\"ordersdetail.php?orderid=".$_GET['orderid']."\">
       */
   $homepage->content = 
      "
       <form method=\"POST\" >
       <br>\n
       <h3>".$header."</h3>
       <br>\n                 
       <table border=1px bordercolor=\"black\">
        <tr>
           <td class=\"headers\"> Κωδικός  </td>
           <td class=\"headers\"> Ονομασία  </td>
           <td class=\"headers\"> Μον.Μετρ.  </td>
           <td class=\"headers\"> Τιμή  </td>
           <td class=\"headers\"> Ποσότητα  </td>
           <td class=\"headers\"> Αξία  </td>
        <tr>   
     "; 
       $summary=0;
       while($row=$result->fetch_assoc()){
           $homepage->content = $homepage->content.
           "<tr>
              <td>".$row['itemid']."</td>
              <td>".$row['descr']."</td>
              <td>".$row['mm']."</td>
              <td>".$row['price']."</td>
              <td>".$row['quantity']."</td>
              <td>".($row['price'] * $row['quantity'])."</td> 
           </tr>";
              $summary = $summary + ($row['price'] * $row['quantity']);
       }
       
       $homepage->content = $homepage->content.
       "</table>\n".
       "Συνολική αξία παραγγελίας: ".$summary;
       
       $button = "";
       if (isset($_SESSION['admin']) and ($status < 4)){
          $button = "<input type=\"submit\" name=\"UpdateStatus\" value=\"".
                    $homepage->Order_Status[$status +1 ]."\"/>"; 
                          
                    $homepage->content = $homepage->content."<br> Αλλαγή κατάστασης σε".$button;
       }
       
       
  
   
   

  $db->close();
  $homepage->Display();  
  
  
?>

   
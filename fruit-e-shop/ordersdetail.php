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
        <div class=\"container\">
       <div class=\"bs-docs-section\">
        <div class=\"row\">
          <div class=\"col-lg-12\">
            <!--<div class=\"page-header\">
              <h1 id=\"tables\">Οι παραγγελίες μου</h1>
            </div>-->
			<h3>".$header."</h3>
            <div class=\"bs-component\">
              <table class=\"table table-striped table-hover\">
                <thead>
                  <tr>
                    <th>Κωδικός</th>
                    <th>Ονομασία</th>
                    <th>Μον.Μέτρησης</th>
                    <th>Τιμή</th>
                    <th> Ποσότητα  </th>
				     <th> Αξία  </th> 
                  </tr>
                </thead>
                <tbody>"; 
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
       "<tr class=\"info\">
       <td></td>
       <td>Σύνολο</td>
       <td></td>
       <td></td>
       <td></td>
       <td>".$summary."</td>
       </tr>";
       
       $homepage->content = $homepage->content.
       "</tbody></table>"; 
       
       
       $button = "";
       if (isset($_SESSION['admin']) and ($status < 4)){
          $button = "<input type=\"submit\" class=\"btn btn-warning\" name=\"UpdateStatus\" value=\"".
                    $homepage->Order_Status[$status +1 ]."\"/>"; 
                          
                    $homepage->content = $homepage->content."<br> Αλλαγή κατάστασης σε".$button;
       }
       
       
       $homepage->content .= "</div></div></div></div></div>\n";
   
   

  $db->close();
  $homepage->Display();  
  
  
?>

   
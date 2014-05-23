 <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  $errors = "False";
  
  if (!isset($_SESSION['valid_user'])) {
     die("Δεν είστε εγγεγραμένος χρήστης");
  }
  if (!isset($_SESSION['cart'])) {
     die("Το καλάθι σας είναι άδειο");
  }
  
  
  
  $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
  if (mysqli_connect_errno()) {
      die("Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.");
  } else {
      date_default_timezone_set('Europe/Athens');
      $date = date('Y-m-d');
      mysqli_autocommit($db, FALSE);
      $db->query("SET CHARACTER SET 'utf8'");
      $InsertQ = "insert into orders values(NULL, '".$date."', ".$_SESSION['summary'].
                  ", '".$_SESSION['valid_user']."', 0, 'Αντικαταβολή')";
      $result = $db->query($InsertQ);
         if (!$result) {
              $db->close();
              die("Δεν είναι δυνατή η καταχώρηση της παραγγελίας.Προσπαθήστε αργότερα");
         } else {
              $orderid = $db->insert_id;
              /*echo "ordernumber".$orderid."<br>"; */
              while (list($item, $qty) = each($_SESSION['cart'])){
                   $SelectQ = "Select price from items where itemid=".$item;
                   $result1 = $db->query($SelectQ);
                   
                   if (!$result1) {
                    /*echo "error on price of item ".$item; */
                    $homepage->content = "Δεν είναι δυνατή η καταχώρηση της παραγγελίας. Προσπαθήστε αργότερα.";
                    $errors = "True";
                    $db->rollback();
                    $db->close();
                    break 2;
                   }
                   /*echo "item".$item;  */
                   $row = $result1->fetch_assoc();
                   $price = $row['price'];
                   /*echo "price".$price; */
                   $InsertQ = "insert into ordered_items values(".
                                                            $orderid.", ".
                                                            $item.", ".
                                                            $qty.", ".
                                                            $price.")";
                   $result = $db->query($InsertQ);
                   /*echo $InsertQ."<br>"; */
                   if (!$result) {
                    /*echo "error on insert of item ".$item."<br>"; */
                    $homepage->content = "Δεν είναι δυνατή η καταχώρηση της παραγγελίας. Προσπαθήστε αργότερα.";
                    $errors = "True";
                    $db->rollback();
                    $db->close();
                    break 2;
                   }
                   
              }    
         }      
  }
      
   
   
  if ($errors == "False"){
     $db->commit();
     mysqli_autocommit($db, TRUE);
     $db->close();
     unset($_SESSION['cart']);
     unset($_SESSION['summary']);
	mail($homepage->GetAdminEmails(), $homepage->email_subject, "New order from ".$_SESSION['valid_user'],
                                  $homepage->email_headers);
     $homepage->content = "Η παραγγελία σας καταχωρήθηκε με επιτυχία.<br>
                          Μπορείτε να ενημερώνεστε από την ιστοσελίδα μας
                          για την πορεία της.<br>
                          Ευχαριστούμε για την προτίμησή σας." ;
  }
  
    
	$homepage->Display();    
?>





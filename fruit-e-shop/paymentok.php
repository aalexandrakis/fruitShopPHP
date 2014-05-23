<?php
  session_id($_POST['custom']);
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  $errors = "False";
  $Error_Message = "";


  if (!isset($_SESSION['valid_user'])) {
     $Error_Message="Δεν είστε εγγεγραμένος χρήστης";
     $errors="True";
  }
  
  if ($_POST['payment_status']!="Completed"){
      $Error_Message = $_POST['payment_status'];
      $errors="True"; 
  }  
  
  if (!isset($_POST['num_cart_items'])){
       $_SESSION['cart'] = array();
       $itemnumber = $_POST['item_number'];
       $_SESSION['cart'][$itemnumber] = $_POST['quantity']; 
      
  }

  if (!isset($_SESSION['cart'])) {
     $Error_Message="Το καλάθι σας είναι άδειο";
     $errors="True"; 
  }

  $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
  if (mysqli_connect_errno() && $errors=="False") {
      $Error_Message="Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
      $errors="True";
  } else {
      date_default_timezone_set('Europe/Athens');
      $date = date('Y-m-d');
      mysqli_autocommit($db, FALSE);
      $db->query("SET CHARACTER SET 'utf8'");
      $InsertQ = "insert into orders values(NULL, '".$date."', ".$_POST['mc_gross'].
                  ", '".$_SESSION['valid_user']."', 0, '".$_POST['txn_id']."')"; 
      $result = $db->query($InsertQ);
         if (!$result) {
              $db->close();
              $Error_Message="Cannot insert header record";
	      $errors="True";
         } else {
              $orderid = $db->insert_id;
              reset($_SESSION['cart']);
              while (list($item, $qty) = each($_SESSION['cart'])){
                   $SelectQ = "Select price from items where itemid=".$item;
                   $result1 = $db->query($SelectQ);
                   
                   if (!$result1) {
                    $Error_Message = "Cannot get price from table items";
                    $errors = "True";
                    $db->rollback();
                    $db->close();
                    break 2;
                   }
                   $row = $result1->fetch_assoc();
                   $price = $row['price'];
                   $InsertQ = "insert into ordered_items values(".
                                                            $orderid.", ".
                                                            $item.", ".
                                                            round($qty).", ".
                                                            $price.")";
                   $result = $db->query($InsertQ);
                   if (!$result) {
                    $Error_Message = "Cannot insert item".$item;
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
                                  "support@fsalexandrakis.gr");
  } else {
	$db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
  	if (!mysqli_connect_errno()) {
                date_default_timezone_set('Europe/Athens');
		$date = date('Ymd');
                $InsertQ = "insert into ErrorLog values('".
                                                   $date."', '".
                                                   $_POST['txn_id']."', '".
                                                   $Error_Message."')";
                $db->query("SET CHARACTER SET 'utf8'");
                $result = $db->query($InsertQ);
	}
		mail($homepage->GetAdminEmails(), $homepage->email_subject, $Error_Message,
                                  "New Order Error");

   
  }
    
?>





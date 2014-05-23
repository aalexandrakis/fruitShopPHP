<?php
   include_once('standars.php');  
    $response = array();
    if (!isset($_REQUEST['email'])){
         die("0 email not set");
    }
    
    $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
          die("0 mysqli failed");
      } else {
         $sqlQuery = "Select * from orders where username='".$_REQUEST['email']."' order by orderid desc";
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($sqlQuery);
         if (!$result) {
            die("0 sql query failed ".$sqlQuery);
         }
         $dom = new DomDocument("1.0", "utf-8");
         $orders = $dom->createElement('orders');
         while ($row = mysqli_fetch_assoc($result)){

             $order = $dom->createElement('order');
             $order->setAttribute("orderid", $row['orderid']);
             $order->setAttribute("orderdate", $row['date']);
             $order->setAttribute("orderamount", $row['ammount']);
             $order->setAttribute("orderstatus", utf8_encode($Order_Status[$row['status']]));
             //$orderid = $dom->createElement('orderid', $row['orderid']);
             //$order->appendChild($orderid);
             //$orderdate = $dom->createElement('orderdate', $row['date']);
             //$order->appendChild($orderdate);
             //$orderamount = $dom->createElement('orderamount', $row['ammount']);
             //$order->appendChild($orderamount);
             //$orderstatus = $dom->createElement('orderstatus');
             //$orderstatus_text = $dom->createtextnode(utf8_encode($Order_Status[$row['status']]));
             //$orderstatus->appendChild($orderstatus_text);
             //$order->appendChild($orderstatus);
             
             $orders->appendChild($order);
               
         }
         $dom->appendChild($orders);   
         $db->close();
         echo $dom->saveXML();
      }   

?>	
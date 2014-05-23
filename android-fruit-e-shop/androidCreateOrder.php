<?php
    require_once("standars.php");
    
    if(!isset($_REQUEST['email']) or $_REQUEST['email']==""){
       die("0 email not set or empty"); 
    }
    if(!isset($_REQUEST['orderXML'])){
       die("0 order_string_XML not set"); 
    }
    //$orderXML = utf8_encode($_REQUEST['orderXML']);
    $orderXML = $_REQUEST['orderXML'];
  
    $xml = new DOMDocument("1.0", "utf-8");
    if (!$xml->loadXML($orderXML)){
          die("0 errorXML encoding");
    }
    
    $items = $xml->getElementsByTagName("item");
    $OrderAmount = 0;
    foreach ($items as $item){
	  $OrderAmount = $OrderAmount + ($item->getAttribute("itemquan") * $item->getAttribute("itemprice"));
    }   

$db = new mysqli($hostname, $user_name, $user_password, $dbname);
  if (mysqli_connect_errno()) {
      die("0 mysqli connection error");
  } else {
      date_default_timezone_set('Europe/Athens');
      $date = date('Y-m-d');
      mysqli_autocommit($db, FALSE);
      $db->query("SET CHARACTER SET 'utf8'");
      $InsertQ = "insert into orders values(NULL, '".$date."', ".$OrderAmount.
                  ", '".$_REQUEST['email']."', 0, ' ')";
      $result = $db->query($InsertQ);
         if (!$result) {
              $db->close();
              die("0 could not write header");
         } else {
              $orderid = $db->insert_id;
	      foreach ($items as $item){
         	    $InsertQ = "insert into ordered_items values(".
                                                            $orderid.", ".
                                                            $item->getAttribute("itemid").", ".
                                                            $item->getAttribute("itemquan").", ".
                                                            $item->getAttribute("itemprice").")";
                   	$result = $db->query($InsertQ);
                        if (!$result) {
			    $db->rollback();
                            $db->close();
	                    die("0 could not write detail-".$item['itemid']);
                   	}
        
	        }
        }
  }
 $db->commit();
 $db->close(); 
	mail("aalexandrakis@hotmail.com", "Fruit shop Alexandrakis", "New order from ".$_REQUEST['email'],
                                  "support@fsalexandrakis.gr");

 echo  "1";
?>
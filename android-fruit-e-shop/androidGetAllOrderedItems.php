<?php
   include_once("standars.php");  

    if (!isset($_REQUEST['email'])){
         die("0 not set email");
    }
    
    $dom = new DomDocument("1.0", "utf-8");
    $sqlQuery = "Select * from ordered_items inner join items using (itemid) where orderid in (select orderid from orders where username='".$_REQUEST['email']."') order by orderid";
    $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
         die("0 mysqli connection error");
      } else {
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($sqlQuery);
         if (!$result) {
            die("0 sqlQuery error ".$sqlQuery);
         }
         $items = $dom->createElement('items');
         while ($row = mysqli_fetch_assoc($result)){
              //echo $row['descr']."<br>";
              $item = $dom->createElement('item');
              $item->setAttribute('orderid', $row['orderid']);
              $item->setAttribute("itemid", $row['itemid']);
              $item->setAttribute("itemdescr", $row['descr']);
              $item->setAttribute("mm", $row['mm']);
              $item->setAttribute("price", $row['price']);
              $item->setAttribute("quantity", $row['quantity']);
              $item->setAttribute("itemsummary", $row['quantity'] * $row['price']);

              //$itemid = $dom->createElement('itemid', $row['itemid']);
              //$item->appendChild($itemid);
              // 
              //$itemdescr = $dom->createElement('itemdescr');
              //$itemdescr_text = $dom->createtextnode($row['descr'] );
              //$itemdescr->appendchild($itemdescr_text);
              //$item->appendChild($itemdescr);
              //
              //$item_mm = $dom->createElement('mm');
              //$item_mm_text = $dom->createtextnode($row['mm'] );
              //$item_mm->appendchild($item_mm_text);
              //$item->appendChild($item_mm);
              //
              //$item_price = $dom->createElement('price');
              //$item_price = $dom->createElement('price', $row['price']);
              //$item->appendChild($item_price);
              // 
              //$item_quantity = $dom->createElement('quantity');
              //$item_quantity = $dom->createElement('quantity', $row['quantity']);
              //$item->appendChild($item_quantity);
              //
              //$item_summary = $dom->createElement('itemsummary');
              //$item_summary = $dom->createElement('itemsummary', $row['quantity'] * $row['price']);
              //$item->appendChild($item_summary);
 
              //
               
              $items->appendChild($item);
         }
         $dom->appendChild($items);
         $db->close();
         echo $dom->saveXML(); 
      }   

?>
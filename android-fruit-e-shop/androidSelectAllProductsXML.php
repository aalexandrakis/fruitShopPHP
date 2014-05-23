<?php
   include_once("standars.php");  

    
    $dom = new DomDocument("1.0", "utf-8");
    $sqlQuery = "Select * from items where display=1 order by categoryid, descr";
    $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
         $response['success'] = 0;
         exit;    
      } else {
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($sqlQuery);
         if (!$result) {
            $response['success'] = 0;
            exit;
         }
         $items = $dom->createElement('items');
         while ($row = mysqli_fetch_assoc($result)){
              //echo $row['descr']."<br>";
              $item = $dom->createElement('item');
              $item->setAttribute("catid",$row['categoryid']);
              $item->setAttribute("itemid",$row['itemid']);
              $item->setAttribute("itemdescr",$row['descr']);
              $item->setAttribute("mm",$row['mm']);
              $item->setAttribute("price",$row['price']);
               
              //$catid = $dom->createElement('catid', $row['categoryid']);
              //$item->appendChild($catid);
              //
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
              $items->appendChild($item);
         }
         $dom->appendChild($items);
         $db->close();
         echo $dom->saveXML(); 
      }   

?>
<?php
   include_once("standars.php");  
    $sqlQuery = "Select * from items_category";
    // 1st param takes version and 2nd param takes encoding;
    $dom = new DomDocument("1.0", "utf-8");
     
     
    $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
         die("0 mysqli error");
      } else {
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($sqlQuery);
         if (!$result) {
            die("0 query failed");
         }
          
         $categories = $dom->createElement('categories'); 
         
         while ($row = mysqli_fetch_assoc($result)){
          /*echo  $row['descr']; */
              $category = $dom->createElement('category');
              $category->setAttribute("categoryid", $row['categoryid']);
              $category->setAttribute("categoryname", $row['category']);
              $categories->appendChild($category);
              //$categoryid = $dom->createElement('categoryid', $row['categoryid']);
              //$category->appendChild($categoryid);
              //$categoryname = $dom->createElement('categoryname', $row['category']);
              //$category->appendChild($categoryname);
              //$categoryname = $dom->createElement('categoryname');
              //$categoryname_text = $dom->createtextnode($row['category'] );
              //$categoryname->appendchild($categoryname_text);
              //$category->appendChild($categoryname);
           }
           $dom->appendChild($categories);
           $db->close();
         
         //echo $dom->save('members.xml');
         echo trim($dom->saveXML());
         
      }    

?>
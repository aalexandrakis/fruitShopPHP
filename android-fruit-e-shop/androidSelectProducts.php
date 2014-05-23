<?php
   include_once("standars.php");  
    $response = array();
    if (!isset($_GET['catid'])){
         $response['success'] = 0;
         $response['message'] = "Connection to database failed";
         echo json_encode($response);    
         exit;
    }
    
    if (!isset($_GET['lastDate'])) {
       $sqlQuery = "Select * from items where categoryid=".$_GET['catid'];
    }  else {
       $sqlQuery = "Select * from items where categoryid=".$_GET['catid']. " and lastDate >= ".$_GET['lastDate'];
    }
    
    $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
         $response['success'] = 0;
         $response['message'] = "Connection to database failed";
         echo json_encode($response);
         exit;    
      } else {
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($sqlQuery);
         if (!$result) {
            $response['success'] = 0;
            $response['message'] = "Connection to database failed";
            echo json_encode($response);
            exit;
         }
         $response['products'] = array();
         while ($row = mysqli_fetch_assoc($result)){
          /*echo  $row['descr']; */
          $itemrecord = array("itemId" => $row['itemid'], 
                              "descr" => $row['descr'],
                              "mm" => $row['mm'],
                              "price" => $row['price']) ;
              array_push($response['products'], $itemrecord);                
         }
         $response['success'] = 1;
         echo json_encode($response);    
         $db->close();
      }   

?>
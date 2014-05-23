<?php
   include_once("standars.php");  
    $response = array();
       $sqlQuery = "Select * from items_category";
    
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
         $response['categories'] = array();
         while ($row = mysqli_fetch_assoc($result)){
          /*echo  $row['descr']; */
          $catrec = array("categoryid" => $row['categoryid'], 
                              "category" => $row['category']);
              array_push($response['categories'], $catrec);                
         }
         $response['success'] = 1;
         echo json_encode($response);    
         $db->close();
      }   

?>
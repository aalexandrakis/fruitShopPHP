<?php
   include_once('standars.php');  
    $response = array();
    if (!isset($_GET['username'])){
         $response['success'] = 0;
         $response['message'] = "Required fields missing";
         echo json_encode($response);    
         exit;
    }
    if (!isset($_GET['ammount'])){
         $response['success'] = 0;
         $response['message'] = "Required fields missing";
         echo json_encode($response);    
         exit;
    }
    
    $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
         $response['success'] = 0;
         $response['message'] = "Connection to database failed";
         echo json_encode($response);
         exit;    
      } else {
         date_default_timezone_set('Europe/Athens');
         $date = date('Y-m-j');
         mysqli_autocommit($db, FALSE);
         $sqlQuery = "insert into orders values(NULL, '".$date."', ".$_GET['ammount'].
                  ", '".$_GET['username']."', 0)";
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($sqlQuery);
         if (!$result) {
            $response['success'] = 0;
            $response['message'] = "Header not added";
            echo json_encode($response);
            exit;
         } else {
            $response['orderid'] = $db->insert_id;
            $response['success'] = 1;
            $response['message'] = "Orders header added succesfully";               
         }
         
         echo json_encode($response);   
         $db->commit();
         mysqli_autocommit($db, TRUE);
         $db->close();
      }   
      
  
?>
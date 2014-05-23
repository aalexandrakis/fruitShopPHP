<?php
    include_once("standars.php"); 
    if (!isset($_POST["username"])){
         $response = 5;
         echo $response;    
         exit;
    }
    if (!isset($_POST["password"])){
         $response = 0;
         echo $response;    
         exit;
    }
    
    $sqlQuery = "Select * from customers where email='".$_POST['username']."' and password='".sha1($_POST['password'])."'";
    $db = new mysqli($hostname, $user_name, $user_password, $dbname);


      if (mysqli_connect_errno()) {
         $response = 0;
         echo $response;    
         exit;    
      } else {
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($sqlQuery);
         if ($result->num_rows <= 0) {
            $response = 0;
            echo $response;    
            exit;
         } else {
            $response = 1;
            echo $response;    
            exit;
         }
      } 
    
?>
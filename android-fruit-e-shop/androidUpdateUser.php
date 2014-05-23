<?php
  require_once("standars.php");
  
  if (!isset($_POST['name'])){
      die("0 name is missing");
  }
  if (!isset($_POST['address'])){
      die("0 address is missing");
  }
  if (!isset($_POST['city'])){
      die("0 city is missing");
  }
  if (!isset($_POST['phone'])){
      die("0 phone is missing");
  }
  if (!isset($_POST['email'])){
      die("0 email is missing");
  }
  if (!isset($_POST['password'])){
      die("0 password is missing");
  }
  
  
      $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
          die("0 mysqli connection error");
      } else {
        $db->query("SET CHARACTER SET 'utf8'");
        $updateQ = "Update customers set ".
                   "name = '".$_POST['name']."', ".
                   "address = '".$_POST['address']."', ".
                   "city = '".$_POST['city']."', ".
                   "phone = '".$_POST['phone']."', ".
                   "password = '".sha1($_POST['password'])."' ".
                   "where email = '".$_POST['email']."'";
         $result = $db->query($updateQ);
         $db->close();
         if (!$result) {
             die("0 update failed ".$UpdateQ); 
         } else {
             die("1");
         }
      }   
  
?>
<?php
  require_once("standars.php");
  
  if (isset($_POST['name'])){
     $name = $_POST['name'];}
  if (isset($_POST['address'])){   
     $address = $_POST['address'];}
  if (isset($_POST['city'])){
     $city = $_POST['city'];}
  if (isset($_POST['phone'])){
     $phone = $_POST['phone'];}
  if (isset($_POST['email'])){
     $email = $_POST['email'];}
  if (isset($_POST['password'])){
     $password = $_POST['password'];}
  
  if ((isset($_POST['name'])) && ($_POST['name'] == "")) {
       die("0 name is blanks");}
  else if ((isset($_POST['address'])) && ($_POST['address'] == "")) {
       die("0 address is blanks");} 
  else if ((isset($_POST['city'])) && ($_POST['city'] == "")) {
       die("0 city is blanks");}
  else if ((isset($_POST['phone'])) && ($_POST['phone'] == "")) {
       die("0 phone is blanks"); }
  else if ((isset($_POST['email'])) && ($_POST['email'] == "")) {
       die("0 email is blanks");}
  else if ((isset($_POST['password'])) && ($_POST['password'] == "")) {
       die("0 password is blanks");}
  
  

  
     $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
          die("0 hostname=".$hostname." username=".$user_name." password=".$user_password." dbname=".$dbname);
      } else {
         mysqli_autocommit($db, FALSE);
         $SelectQ = "select * from  customers where email=\"".$_POST['email']."\"";
          $result = $db->query($SelectQ);
          if ($result->num_rows > 0 ) {
            die("2");
            $db->close();
          }
       
      }
 
          
  
      $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
          die("0 hostname=".$hostname." username=".$user_name." password=".$user_password." dbname=".$dbname);
      } else {
        $db->query("SET CHARACTER SET 'utf8'");
        $insertQ = "Insert into customers values(NULL, \"".
                   $_POST['name']."\",\"".
                   $_POST['address']."\",\"".
                   $_POST['city']."\",\"".
                   $_POST['phone']."\",\"".
                   sha1($_POST['password'])."\",\"".
                   $_POST['email']."\", 0)";
         $result = $db->query($insertQ);
         if (!$result) {
           $db->rollback();
           die("0 ". $insertQ);
         }
         $db->commit();
         mysqli_autocommit($db, TRUE);
         $db->close();
		mail("aalexandrakis@hotmail.com", "Fruit shop Alexandrakis", "New user ".$_POST['email'],
                                  "support@fsalexandrakis.gr");

         die("1");
        }
           
  
?>
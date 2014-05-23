<?php
  require_once("standars.php");
  
  if (!isset($_REQUEST['email'])){
      die("0 email is missing");
  }
  
  $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
          die("0 error in mysqli connection");
      } else {
         $db->query("SET CHARACTER SET 'utf8'");
         $SelectQ = "select * from  customers where email=\"".$_REQUEST['email']."\"";
          $result = $db->query($SelectQ);
          if ($result->num_rows > 0 ) {
            $row = mysqli_fetch_row($result);
            $name = $row[1];
            $uaddress = $row[2];
            $ucity = $row[3];
            $uphone = $row[4];
            $email = $row[6];
            $db->close();


            $dom = new DomDocument("1.0", "utf-8");
            $user_info = $dom->createElement('user_info');
            
            $user = $dom->createElement('user');
            
            $username = $dom->createElement('username');
            $username_text = $dom->createtextnode($name);
            $username->appendChild($username_text);
            $user->appendChild($username);

            $address = $dom->createElement('address');
            $address_text = $dom->createtextnode($uaddress);
            $address->appendChild($address_text);
            $user->appendChild($address);
            
            $city = $dom->createElement('city');
            $city_text = $dom->createtextnode($ucity);
            $city->appendChild($city_text);
            $user->appendChild($city);
            
            $phone = $dom->createElement('phone');
            $phone_text = $dom->createtextnode($uphone);
            $phone->appendChild($phone_text);
            $user->appendChild($phone);  

            $user_info->appendChild($user);
            $dom->appendChild($user_info);
            
            echo $dom->saveXML();
          } 
     }

?>
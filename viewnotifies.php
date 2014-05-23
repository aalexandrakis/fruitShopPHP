<?php
  
         $dbname = "637352";
	$hostname = "localhost";
	$user_name = "637352" ;
        $user_password = "b12021982";
	$db = new mysqli($hostname, $user_name, $user_password, $dbname);
        
	if (mysqli_connect_errno()) {
            exit;
        } else {
          $insertQ = "select * from testTable";
	  $db->query("SET CHARACTER SET 'utf8'");
          $result = $db->query($insertQ);
          while ($row=$result->fetch_assoc()){
		echo $row['TestField'];
                echo "<br>";
          }
	}
        $db->close();
 
 //echo $output;
?>
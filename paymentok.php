<?php
  
  if (isset($_POST['custom'])){
  	session_id($_POST['custom']);
	session_start();
  }
 	 foreach ($_POST as $key=>$value) {
	      $output = "NOTIFY_POST:".$key."=>".$value;
              insertInto($output);
         }
      
	 foreach ($_GET as $key=>$value) {
	      $output = "NOTIFY_GET:".$key."=>".$value;
              insertInto($output);
         }

	 foreach ($_SESSION as $key=>$value) {
	      $output = "NOTIFY_SESSION:".$key."=>".$value;
              insertInto($output);
         }
        
 
  
 function insertInto($output){
        $dbname = "637352";
	$hostname = "localhost";
	$user_name = "637352" ;
        $user_password = "b12021982";
	$db = new mysqli($hostname, $user_name, $user_password, $dbname);
        
	if (mysqli_connect_errno()) {
            exit;
        } else {
          $insertQ = "insert into testTable values('".$output."')";
	  $db->query("SET CHARACTER SET 'utf8'");
          $result = $db->query($insertQ);
          if (!$result) {
             echo "failed";
          } else {
             echo "ok";
             $db->commit();
          }
          $db->close();
	}
 }   
 
 //echo $output;
?>
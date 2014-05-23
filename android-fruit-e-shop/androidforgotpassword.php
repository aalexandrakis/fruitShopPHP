<?php
  include_once("standars.php"); 
  if ((isset($_POST['email'])) ) {
    $db = new mysqli($hostname, $user_name, $user_password, $dbname);
      if (mysqli_connect_errno()) {
          $confirmation = 0;
      } else {
         $SelectQ = "select * from  customers where email=\"".$_POST['email']."\"";
          $result = $db->query($SelectQ);
          if ($result->num_rows <= 0 ) {
            $confirmation = 1;
            $db->close();}
            else { 
              $newpass="";
              for ($i=1;$i<7;$i=$i+1) {
                $newpass = $newpass.$Characters[rand(1,26)]; 
              }  
                $newpass = $newpass.rand(0,26);
                //$newpass = "a12021982";
                $db->query("SET CHARACTER SET 'utf8'");
                mysqli_autocommit($db, FALSE);
                $UpdateQ = "update customers set password='".sha1($newpass)."' where email=\"".$_POST['email']."\"";
                $result = $db->query($UpdateQ);
                if (!$result) {
                   $confirmation = 0;
                } else {
                  $msg = "Your new password is ".$newpass;
                  if (mail($_POST['email'], 'Fruit shop Alexandrakis login information', $msg, 
                                  'support@fsalexandrakis.gr')){
                                  
                      $confirmation = 3;
                      $db->commit();
                    } else {
                      $confirmation = 2;
                      $db->rollback();
                      
                    }   
                }      
                mysqli_autocommit($db, TRUE);   
                $db->close();
          }
      }
  }
  
  echo $confirmation;
  
?>





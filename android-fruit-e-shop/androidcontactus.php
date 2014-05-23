<?php
  $confirmation ="";
      include_once("standars.php"); 
      if (mail($myEmail, $_POST['subject'], $_POST['$mail'], $_POST['$yoursmail'])){
         $confirmation = "1" ;
      } else {
         $confirmation = "0" ;
      }
      echo $confirmation; 
  
?>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
 
 
 
  $homepage->DisplayRandomItems = "True";
  
  $homepage->content =
    " 
        <br>\n
          <div class=\"well\" >\n
             <dl>\n
               <dt> Αλεξανδράκης Αλέξανδρος </dt>\n
                  <dd> Υπεύθυνος προμηθειών </dd>\n
          	   <dt> Μπαλκουρανίδου Αγγελική </dt>\n
		  			      <dd> Υπεύθυνη πωλήσεων </dd>\n
	  		     </dl>\n
          </div>"; 
  
	$homepage->Display();
  
 
?>
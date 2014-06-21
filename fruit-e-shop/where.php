 <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->content = 
         "
          <br>\n
          <div class=\"well\" >
                                                                          
      			 Βρισκομαστε στη Νεα Ελβετια του Βυρωνα στην Οδο Βουτζα 12-20.
		      </div>
          "; 
      
	$homepage->Display();
?>
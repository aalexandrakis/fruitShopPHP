 <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->content = 
         "
          <br>\n
          <div class=\"container\" >\n
          <div class=\"row\">
          <div class=\"col-lg-12\">
            <div class=\"bs-component\">
              <blockquote>
                                                                          
      			 Βρισκομαστε στη Νεα Ελβετια του Βυρωνα στην Οδο Βουτζα 12-20.
      			 </blockquote>
		      </div></div></div></div>
          "; 
      
	$homepage->Display();
?>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  unset($_SESSION['valid_user']);
  unset($_SESSION['admin']);
  unset($_SESSION['cart']);
  unset($_SESSION['summary']);
  session_destroy();
  $homepage->content = "Αποσυνδεθήκατε";
	$homepage->Display();
?>





 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php
  session_start();
  require("page.inc");
  
  /*echo $homepage->path;*/  
  $homepage=new Page();
  $homepage->Set_Path();
  $homepage->SetJsFile="Photos.js";
   
    
  //$Directory = "/home/vhosts/aalexandrakis.freevar.com/fruit-e-shop/images/";
  //$Directory= "C:/wamp/www/fruit-e-shop/images/";
    $Directory=__DIR__."/images/";
  
  $Dir_Photos =  glob($Directory . "{*.JPG,*.gif}", GLOB_BRACE);
  $images_arr = array();
  $ImageCount=0;   
    foreach($Dir_Photos as $image){
        $path_parts = pathinfo($image);
        $images_arr[$ImageCount] = $homepage->path."/images/".$path_parts['filename'].".".$path_parts['extension'];
  	    $ImageCount = $ImageCount+1;
    }
    $currentimage=$images_arr[0];
  
    $homepage->content = 
   "<form action=\"photos.php\" method=\"GET\">
    
      <input type=\"hidden\" id=\"images_arr\" value=\"".implode("#",$images_arr)."\">
      <input type=\"hidden\" id=\"ImageCount\" value=".$ImageCount.">
      <input type=\"hidden\" id=\"currentimage\" value=\"".$currentimage."\">
     

    <br>\n
    <div class=\"container\" >\n
    <div class=\"bs-docs-section\" >\n
    <div class=\"row\" >\n
    <div class=\"col-lg-12\" >\n 
    <div class=\"bs-component\" >\n
    <ul class=\"pager\">
    <li id=\"previous\" class=\"previous\" style=\"display:none\">
    	<a href=\"#\"  onclick=\"GetPreviousImage()\"><<</a>\n
    </li>
    <li>   <img id=\"mainphoto\" src=\"".$currentimage."\" alt=\"Main Photo\" width=\"80%\" height=\"65%\"/>\n</li>
    <li id=\"next\" class=\"next\">
    	<a href=\"#\"  onclick=\"GetNextImage()\">>></a>\n
    </li>	
    <br>\n
    </div>
    </div>
    </div>
   </div>
   </div>"; 
      
	$homepage->Display();
?>					
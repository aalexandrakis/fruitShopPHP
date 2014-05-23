    <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php 
  session_start();
  include ('page.inc');
  $homepage=new Page();
  $homepage->Set_Path();
  $homepage->SetJsFile="mycart.js";

  /*if (!isset($_SESSION['valid_user'])) {
      die("Πρέπει να συνδεθείς για να κάνεις παραγγελία.");
  }*/
   
  /*if (isset($_POST['delete'])) {*/   
        if (isset($_POST['delitem'])){
           foreach ($_POST['delitem'] as $itemD){
              $homepage->RemoveFromCart($itemD);
           }
        }
  /*} */
  
  if (isset($_POST['itemid']) && isset($_POST['quantity'])) {
     $homepage->AddToCart($_POST['itemid'], $_POST['quantity']);
  }



  if (isset($_SESSION['cart'])) {  
     $homepage->content = 
      "
       <form name=\"UploadCart\" method=\"POST\">
       <br>\n
       <h3>Το καλάθι μου </h3>
       <br>\n                 
       <table border=1px bordercolor=\"black\">
           <tr>
              <td class=\"headers\"> Κωδικός  </td>
              <td class=\"headers\"> Ονομασία  </td>
              <td class=\"headers\"> Μον.Μετρ.  </td>
              <td class=\"headers\"> Τιμή  </td>
              <td class=\"headers\"> Ποσότητα  </td>
              <td class=\"headers\"> Αξία  </td>
              <td>  <input type=\"image\" name=\"delete\" src=\"".$homepage->path."/buttons/deletefromcart.GIF\" onClick=\"return DeleteScript()\"></td>
           <tr>   
        "; 
   
    /*if (!$result) {
    die("error") ;} */
  
           reset($_SESSION['cart']);
           $Counter = 1;
           while (list($item, $qty) = each($_SESSION['cart'])){
            $row = $homepage->GetItemRecord($item);
            $homepage->content =  $homepage->content.
            "<tr>
               <td> ".$item. "</td>
               <td> ".$row['descr']. "</td>
               <td> ".$row['mm']. "</td>
               <td> ".$row['price']. "</td>
               <td> ".$qty."</td>
               <td> ".$row['price'] * $qty."</td>
               <td> <input type=\"checkbox\" name=\"delitem[]\" value=\"".$item."\"/></td>\n
               <input type='hidden' name='amount_".$Counter."' value='".$row['price']."'/>\n
	       <input type='hidden' name='item_name_".$Counter."' value='".$row['descr']."'/>\n
	       <input type='hidden' name='item_number_".$Counter."' value='".$item."'/>\n
               <input type='hidden' name='quantity_".$Counter."' value='".round($qty)."'/>\n
              </tr>\n";  
              ++$Counter;       }
   
       $homepage->content =  $homepage->content. 
 	     "</table>";
        if (isset($_SESSION['valid_user'])) {
               $homepage->content =  $homepage->content. 
               "<input type=\"image\" name=\"createorder\" src=\"".$homepage->path."/buttons/paybutton.GIF\" 
                              onClick=\"this.form.action='confirmorder.php';
                              this.form.submit();\"> \n
				<input type='hidden' name='cmd' value='_cart'/>  
                                <input type='hidden' name='upload' value='1'/>
  			 	<input type='hidden' name='business' value='".$homepage->bussiness_email."'/>
				<input type='hidden' name='currency_code' value='EUR'/>
				<input type='hidden' name='charset' value='UTF-8' />
			 	<input type='hidden' name='country' value='GR'>
			 	<input type='hidden' name='custom' value='".session_id()."'>
				<input type='hidden' name='notify_url' value='".$homepage->notify_url."' />
				<input type='hidden' name='rm' value='2' />
				<input type='hidden' name='return' value='http://aalexandrakis.freevar.com/fruit-e-shop/orders.php' />
   			        <input type='image'  src='https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif' border='0' 
				  		     onClick=\"return UploadCartScript()\" 	   
						     name='submit' alt='PayPal - The safer, easier way to pay online!'/>  
   	                        <img alt='' border='0' src='https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif' width='1' height='1'/>
















                <br>\n
                <a href=\"index.php\">Συνέχισε τις αγορές σου</a>\n";
        } else {
               $homepage->content =  $homepage->content.
               "You must login to finish your order\n
                <br>          
                <a href=\"index.php\">Συνέχισε τις αγορές σου</a>";
        }
      
  } else {
     $homepage->content = "Το καλάθι σας είναι άδειο." ;
  }    
  
 
  $homepage->Display();  
  
  
?>
































































































































   

















































































































































































































































































































































































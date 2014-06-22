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
       <div class=\"container\">
       <div class=\"bs-docs-section\">
        <div class=\"row\">
          <div class=\"col-lg-12\">
            <div class=\"page-header\">
              <h1 id=\"tables\">Το καλάθι μου</h1>
            </div>

            <div class=\"bs-component\">
              <table class=\"table table-striped table-hover\">
                <thead>
                  <tr>
                    <th>Κωδικός</th>
                    <th>Ονομασία</th>
                    <th>Μον.Μέτρησης</th>
                    <th>Ποσότητα</th>
                    <th>Τιμή Μονάδος</th>
                    <th>Αξία</th>
                    <th>Διαγραφή</th>
                  </tr>
                </thead>
                <tbody>"; 
   
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
       	 "<tr class=\"info\">
               <td></td>
               <td>Σύνολο</td>
               <td></td>
               <td></td>
               <td></td>
               <td>".$_SESSION['summary']."</td>
               <td></td>\n
         </tr>\n 
 	     </tbody></table>
         <input type=\"button\" value=\"Διαγρφή\" class=\"btn btn-danger\" onClick=\"return DeleteScript()\"/>";
       if (isset($_SESSION['valid_user'])) {
       	$homepage->content =  $homepage->content.
       	"<a href=\"index.php\"><input type=\"button\" class=\"btn btn-primary\" value=\"Συνέχισε τις αγορές σου\"/></a>\n
       	<input type=\"button\" name=\"createorder\" value=\"Πληρωμή με αντικαταβολή\" class=\"btn btn-success\" onClick=\"this.form.action='confirmorder.php';
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
       
       	<br>\n";
       	} else {
       	$homepage->content =  $homepage->content.
       	"You must login to finish your order\n
       	<br>
       	<a href=\"index.php\">Συνέχισε τις αγορές σου</a>";
       }
        
         $homepage->content .= "</div></div></div></div></div>";
              
  } else {
     $homepage->content = "Το καλάθι σας είναι άδειο." ;
  }    
  
 
  $homepage->Display();  
  
  
?>
































































































































   

















































































































































































































































































































































































 <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  $homepage->SetJsFile="itemdetails.js";
    
  $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
  if (mysqli_connect_errno()) {
      die("Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.");
  }
  mysqli_autocommit($db, FALSE);
  $db->query("SET CHARACTER SET 'utf8'"); 
  

  if ((!isset($_POST['descr'])) and (isset($_GET['itemid']))) {
     
     $SelectQ = "select * from  items inner join items_category using(categoryid) where itemid=".$_GET['itemid'];
          $result = $db->query($SelectQ);
          if (!$result->num_rows > 0 ) {
            die("Δεν βρέθηκε εγγρασφή με αυτό το είδος.");
            $db->close();
          } 
          $row = $result->fetch_assoc();
          $descr = $row['descr'];
          $mm = $row['mm'];
          $price = $row['price'];
          $category = $row['category'];
          $photo = $row['photo'];
          $db->close();
                    
  }
  
  
  
    if (!isset($_GET['itemid'])) {
       die("No item selected");
    }
    $btnAddToCartImage = $homepage->path."/buttons/addtocart.GIF";
    $homepage->content =            
    " <form name=\"BuyNow\"> \n														
       <table>\n
         <tr>\n
	    <td>\n
		<img src=\"".$homepage->path."/productimg/".$photo."\" alt=\"Item Photo\" height=\"300\" width=\"300\">\n
	    </td>\n
            <td>\n
	       <table>\n	
		       <tr>\n
		         <td> Κωδικός </td>\n
		         <td>".$_GET['itemid']."</td>\n
		       </tr>\n
		       <tr>\n
		         <td> Περιγραφή </td>\n
		         <td>".$descr."</td>\n
		       </tr>\n
		       <tr>\n
		         <td> Τιμή </td>\n
		         <td>".$price."</td>\n
		       </tr>\n
		       <tr>\n
		         <td> Μονάδα μέτρησης </td>\n
		         <td>".$mm."</td>\n
		       </tr>\n
		       <tr>\n
		         <td> Κατηγορία </td>\n
		         <td>".$category."</td>\n
		       </tr>\n
		       <tr>\n
		         <td> Ποσότητα </td>
		         <td> <input type=\"text\" name=\"quantity\" value=\"1\" style=\"text-align:right\"/></td>
		       </tr>\n
		       <tr>\n
                         <td>\n
		             <input type=\"hidden\" name=\"itemid\" value=\"".$_GET['itemid']."\"/>
		             <input type=\"image\" name=\"btnAddToCart\" src='".$btnAddToCartImage."' value=\"Add to cart\" onClick=\"return AddToCart()\"/>\n
                         </td>";
                         if (isset($_SESSION['valid_user'])){
                            $homepage->content .=       
			    "<td>
                                <input type='hidden' name='cmd' value='_xclick'/>  
			 	<input type='hidden' name='amount' value='".$price."'/>
				<input type='hidden' name='item_name' value='".$descr."'/>
				<input type='hidden' name='item_number' value='".$_GET['itemid']."'/>
			      	<input type='hidden' name='business' value='".$homepage->bussiness_email."'/>
				<input type='hidden' name='currency_code' value='EUR'/>
				<input type='hidden' name='charset' value='UTF-8' />
			 	<input type='hidden' name='country' value='GR'>
			 	<input type='hidden' name='custom' value='".session_id()."'>
				<input type='hidden' name='notify_url' value='".$homepage->notify_url."' />
				<input type='hidden' name='rm' value='2' />
				<input type='hidden' name='return' value='http://aalexandrakis.freevar.com/fruit-e-shop/orders.php' />
   			        <input type='image'  src='https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif' border='0' 
				  		     onClick=\"return BuyNowScript()\" 	   
						     name='submit' alt='PayPal - The safer, easier way to pay online!'/>  
   	                        <img alt='' border='0' src='https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif' width='1' height='1'/>
                                 
			    </td>";
                        }	
                       $homepage->content .=
 		       "</tr>   	
  	      </table>\n
            </td>\n
         </tr>\n
       </table>\n
      </form>";
//      if (isset($_SESSION['valid_user'])){
//        $homepage->content .=
//        "<form name='BuyNow' action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post' 
//     		  onSubmit='document.BuyNow.quantity.value=Math.round(document.itemdetails.quantity.value);
// 			    document.itemdetails.quantity.value=Math.round(document.itemdetails.quantity.value)'>  
//	  <input type='hidden' name='cmd' value='_xclick'/>  
// 	  <input type='hidden' name='amount' value='".$price."'/>
//	  <input type='hidden' name='item_name' value='".$descr."'/>
//	  <input type='hidden' name='item_number' value='".$_GET['itemid']."'/>
//    	  <input type='hidden' name='quantity' />
//	  <input type='hidden' name='business' value='".$bussiness_email."'/>
//	  <input type='hidden' name='currency_code' value='EUR'/>
//	  <input type='hidden' name='charset' value='UTF-8' />
//	  <input type='hidden' name='country' value='GR'>
// 	  <input type='hidden' name='custom' value='".session_id()."'>
//     	  <input type='hidden' name='notify_url' value='http://www.aalexandrakis.freevar.com/paymentok.php' />
//	  <input type='hidden' name='rm' value='2' />
//     </form> ";
//     }
    
	$homepage->Display();
//<input type='hidden' name='return' value='http://www.aalexandrakis.freevar.com/paymentok.php' />
//<input type=\"hidden\" name=\"hosted_button_id\" value=\"6RNT8A4HBBJRE\">  
//<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">  
//<input type=\"hidden\" name=\"amount\" value=".$price.">
//<input type=\"hidden\" name=\"item_number\" value=\"".$_GET['itemid']."\">
//<form name='BuyNow' action='https://www.sandbox.paypal.com/cgi-bin/webscr' method='post' onSubmit='document.BuyNow.quantity.value=document.itemdetails.quantity.value'>  
//<input type='hidden' name='cancel_url' value='http://www.aalexandrakis.freevar.com/paymentcancel.php' />
//<input type='image'  src='https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'/>  
//<img alt='' border='0' src='https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif' width='1' height='1'/>





?>










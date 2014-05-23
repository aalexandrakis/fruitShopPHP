    <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php 
  session_start();
  include ('page.inc');
  $homepage=new Page();
  $homepage->Set_Path();
   
  $Directory=$homepage->path."/productimg/";
  
    /*if (!isset($_SESSION['valid_user'])) {
      die("Πρέπει να συνδεθείς για να κάνεις παραγγελία.");
  }*/
  
  
  
  if (isset($_POST['qty'])) {
      foreach ($_POST['qty'] as $CartRow) {
      list($item, $qty) = each($_POST['qty']);
          if ($qty > 0 ) {
              $homepage->AddTocart($item, $qty);
          }
      }
      header("Location: ".$homepage->path."/index.php");  
  }
  
  $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          echo "Η συνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ δοκιμάστε αργότερα.";
          exit;
      } else {
         $selectQ = "select * from  items where categoryid = '".$_GET['catid']."' order by descr";
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($selectQ);
      }    
  
   
 if (!isset($_SESSION['admin'])){
   $homepage->content =                                 
   "
    <form  method=\"POST\" name=\"cart\"/>
    <br>\n
       <h3>Δημιουργια παραγγελιας</h3>\n 
       <br>\n
       <span> Βάλε ποσότητα στο προϊόν που θέλεις και πάτα το κουμπί  </span>\n
          
          <input type=\"image\" name\"btn\" src=\"".$homepage->path."/buttons/addtocart.GIF\" onclick=\"this.form.submit();\">
         
    <br>                 
    <table border=1px bordercolor=\"black\">
        <tr>
           <td class=\"headers\"> Φωτογραφία </td>\n 
           <td class=\"headers\"> Κωδικός  </td>   \n
           <td class=\"headers\"> Ονομασία </td>  \n
           <td class=\"headers\"> Μον.Μετρ. </td> \n
           <td class=\"headers\"> Τιμή </td>      \n
           <td class=\"headers\"> Ποσότητα </td>  \n
           
        </tr>   
     ";
     
     while ($row = mysqli_fetch_assoc($result)) {
       if ($row['price']>0) {
           $homepage->content =  $homepage->content.
           "<tr>
              <td> <img alt=\"photo\" id=\"photo\" src=\"".$Directory.$row['photo']."\" width=\"100px\" height=\"100px\"/> </td> \n
              <td> <a href=\"itemdetails.php?itemid=".$row['itemid']."\">".$row['itemid']."</a></td>\n
              <td> <a href=\"itemdetails.php?itemid=".$row['itemid']."\">".$row['descr']. "</a></td>\n
              <td> ".$row['mm']. "</td>     \n
              <td> ".$row['price']. "</td>  \n
              <td> <input type=\"text\" name=\"qty[".$row['itemid']."]\" size=\"6\" maxlength=\"6\" align=\"right\"/></td>\n
             </tr>\n";
      }
    }
    
    $homepage->content =  $homepage->content. 
 	   "</table>
        <input type=\"image\" name\"btn\" src=\"".$homepage->path."/buttons/addtocart.GIF\" onclick=\"document.cart.submit();\">\n
        </form>";  
    
  } else {
   $homepage->content = 
   "
    <form  method=\"POST\" />
    <br>\n
    <h3>Επεξεργασία προϊόντων</h3>\n 
    <br>\n
    <button  name=\"addnew\" onclick=\"this.form.action='item.php';\n
                                       this.form.submit()\">\n
           Προσθήκη νέου είδους\n
    </button> \n                   
    <table border=1px bordercolor=\"black\">
        <tr>
           <td class=\"headers\"> Φωτογραφία </td>\n  
           <td class=\"headers\"> Κωδικός </td>
           <td class=\"headers\"> Ονομασία  </td>
           <td class=\"headers\"> Μον.Μετρ. </td>
           <td class=\"headers\"> Τιμή </td>
        </tr>   
     ";
   while ($row = mysqli_fetch_assoc($result)) {
           $homepage->content =  $homepage->content.
           "<tr>
              <td> <img alt=\"photo\" id=\"photo\" src=\"".$Directory.$row['photo']."\" width=\"100px\" height=\"100px\"/></td> \n
              <td> <a href=\"item.php?itemid=".$row['itemid']. "\">".$row['itemid']."</a></td>
              <td> <a href=\"item.php?itemid=".$row['itemid']. "\">".$row['descr']."</a></td>
              <td> ".$row['mm']. "</td>
              <td> ".$row['price']. "</td>
            </tr>\n";  
    }
    
  $db->close();   

  $homepage->content =  $homepage->content. 
 	   "</table>\n";
  
  }
      
  
   
   

  
  $homepage->Display();  
  
  
?>

   
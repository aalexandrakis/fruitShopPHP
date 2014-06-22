    <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php 
  session_start();
  include ('page.inc');              
  $homepage=new Page();
  $homepage->Set_Path();
  if (!isset($_SESSION['admin']) and (!isset($_SESSION['valid_user']))) {
      die("Δεν έχεις εξουσιοδότηση να δεις αυτή τη σελίδα.");
  }
   
   $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          die("Η συνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ δοκιμάστε αργότερα.");
      } 
      if (isset($_SESSION['admin'])){
         $selectQ = "select * from  orders  where status < 4 order by orderid desc";
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($selectQ);
         $header = "Παραγελίες πελατών";
      }
      else if (isset($_SESSION['valid_user'])){
         $selectQ = "select * from  orders where username = '".$_SESSION['valid_user']."' order by orderid desc";
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($selectQ);
         $header = "Οι παραγελίες μου";
      }    
  
     if (!$result){
       die($selectQ); 
    }
    
     $homepage->content = 
      "
       <form method=\"POST\">
        <div class=\"container\">
       <div class=\"bs-docs-section\">
        <div class=\"row\">
          <div class=\"col-lg-12\">
            <div class=\"page-header\">
              <h1 id=\"tables\">Οι παραγγελίες μου</h1>
            </div>

            <div class=\"bs-component\">
              <table class=\"table table-striped table-hover\">
                <thead>
                  <tr>
                    <th>Κωδικός</th>
                    <th>Ημερομηνία</th>
                    <th>Ποσό</th>
                    <th>Κατάσταση</th>";
				     if (isset($_SESSION['admin'])){
				     	$homepage->content = $homepage->content.
				     	"<th> Χρήστης  </th>
				     	<th> Κωδικός Paypal  </th>";
				     }
				     $homepage->content .= 
                  "</tr>
                </thead>
                <tbody>"; 
      $homepage->content = $homepage->content."</tr>";
      while ($row=$result->fetch_assoc()){
          $homepage->content = $homepage->content.
          "<tr>
              <td> <a href=\"ordersdetail.php?orderid=".$row['orderid']."\">".$row['orderid']."</td>".
             "<td>".$row['date']."</td>".
             "<td>".$row['ammount']."</td>".
	     "<td>".$homepage->Order_Status[$row['status']]."</td>";

             if (isset($_SESSION['admin'])){
                $homepage->content = $homepage->content.
                "<td>".$row['username']."</td>
		 <td>".$row['txn_id']."</td>";

             }
          $homepage->content = $homepage->content."</tr></tbody>";
      }
      
       
      $homepage->content = $homepage->content.
       "</table>\n";
  
  
   
   

  
  $homepage->Display();  
  
  
?>

   
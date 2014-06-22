 <meta http-equiv="content-type" content="text/html; charset=utf-8" >
<?php
  session_start();
  require("page.inc");
  $homepage=new Page();
  $homepage->Set_Path();
  
  if (!isset($_SESSION['admin'])){
     die("Δεν έχεις εξουσιοδότηση να δεις αυτή τη σελίδα");
  }
  $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
  if (mysqli_connect_errno()) {
      die("Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.");
  }
  mysqli_autocommit($db, FALSE);
  $db->query("SET CHARACTER SET 'utf8'"); 
  

     
     $SelectQ = "select * from  customers order by name";
          $result = $db->query($SelectQ);
          if (!$result->num_rows > 0 ) {
            die("No customers exists");
            $db->close();
          } 
          
  
    $homepage->content =            
    "<form name=\"ViewCustomers\" > \n
    <div class=\"container\">
       <div class=\"bs-docs-section\">
        <div class=\"row\">
          <div class=\"col-lg-12\">
            <div class=\"page-header\">
              <h1 id=\"tables\">Μέλη καταστήματος</h1>
            </div>

            <div class=\"bs-component\">
              <table class=\"table table-striped table-hover\">
                <thead>
                  <tr>
                    <th>Κωδικός</th>
                    <th>Όνομα</th>
                    <th>Διεύθυνση</th>
                    <th>Πόλη/Περιοχή</th>
                    <th>Τηλέφωνο</th>
                    <th>Email</th>
                    <th>Ημ.Εγγραφής</th>
                     <th>Τύπος Μέλους</th>
                  </tr>
                </thead>
                <tbody>"; 
     
     $AdminLink = "Διαχειριστής Καταστήματος";
     $MemberLink = "Μέλος Καταστήματος";

     while($row = $result->fetch_assoc()){
        $homepage->content = $homepage->content.
        "<tr>\n".
            "<td>".$row['customerid']."</td>\n".
            "<td>".$row['name']."</td>\n".
            "<td>".$row['address']."</td>\n".
            "<td>".$row['city']."</td>\n".
            "<td>".$row['phone']."</td>\n".
            "<td>".$row['email']."</td>\n".
            "<td>".$row['InsertDate']."</td>\n";
            if ($row['admin'] == 1) {
               $homepage->content = $homepage->content."<td><a href=\"UpdateUserAdmin.php?user_email=".$row['email']."\">".$AdminLink."</a></td>";
            } else {
               $homepage->content = $homepage->content."<td><a href=\"UpdateUserAdmin.php?user_email=".$row['email']."\">".$MemberLink."</a></td>"; 
            }
        $homepage->content = $homepage->content.
        "</tr>"; 
     }
     
     $db->close();
     $homepage->content = $homepage->content.
     "</tbody></table></div></div></div></div>\n".
     "<br>\n"; 
   
   
   
	$homepage->Display();
?>
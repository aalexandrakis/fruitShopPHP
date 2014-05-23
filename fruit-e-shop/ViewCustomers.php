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
     <br>\n                 
    <table border=1px bordercolor=\"black\">
        <tr>
           <td class=\"headers\"> Κωδικός </td>\n 
           <td class=\"headers\"> Όνομα </td>   \n
           <td class=\"headers\"> Διεύθυνση  </td>  \n
           <td class=\"headers\"> Πόλη/Περιοχή</td> \n
           <td class=\"headers\"> Τηλέφωνο </td>      \n
           <td class=\"headers\"> Email </td>  \n
           <td class=\"headers\"> Ημ.Εγγραφής </td>  \n
           <td class=\"headers\"> Μέλος/Διαχειριστής </td>  \n
        </tr>\n   
     ";
     
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
     "</table>\n".
     "<br>\n"; 
   
   
   
	$homepage->Display();
?>
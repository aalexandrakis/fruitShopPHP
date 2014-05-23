 
<?php
Class Page
{
 public $content;
 public $title="Fruit Shop Alexandrakis";
 public $buttons = array ();         
 public $dbname = "637352";
 public $hostname = "localhost";
 public $user_name = "637352" ;
 public $user_password = "b12021982";
 public $path="";
 
 
 /*public $path =  "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);*/
 
 public $Characters = array ( 1 => "a", 2 => "b", 3=>"c", 4=>"d", 5=>"e",
                              6 => "f", 7 => "g", 8=>"h", 9=>"i", 10=>"j",
                              11 => "k", 12 => "l", 13=>"m", 14=>"n", 15=>"o",
                              16 => "p", 17 => "q", 18=>"r", 19=>"s", 20=>"t",
                              21 => "u", 22 => "v", 23=>"w", 24=>"x", 25=>"y",
                              26 => "z");
 
 public $Order_Status = array (0=>"Υπό επεξεργασία",
                               1=>"Ετοιμάζεται",
                               2=>"Έτοιμη για αποστολή",
                               3=>"Έχει αποσταλεί",
                               4=>"Παραδόθηκε");
                               
 
 
 public function __set($name, $value)
 { 
   $this->$name = $value;
 }
 
 
 public function Set_Path() {
   $this->path =  "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
 }

 public function Display()
 {
  echo "<html>\n<head>\n";
  $this->DisplayTitle();
  $this->DisplayStyles();
  echo "</head>\n<body>\n";
  $this->DisplayHeader();
  $this->DisplaySummary();
  /*$this->DisplayDisconectButton();
  $this->DisplayUpdateProfileButton();*/
  $this->DisplayMenu($this->buttons);
  echo $this->content;
  $this->DisplayFooter();
  echo "</body>\n</html>\n";
 }
 
 public Function DisplayTitle()
 {
   echo "<title>".$this->title."</title>";
 }
 
 public function DisplayStyles()
 {
?>
 <style>
h1 { 
	color:white; 
	text-align:center;
	background-color:green;
	
}

h2 {
	color:green;
	text-align:center;
	
	}

div { 
	text-align:center;

}

.Footer {
	border:1px solid black;
  color:white;
  background-color:green;
  
}

.contents (
  text-align:center;
  color:black;
)

ul {
	text-align:left;
}

dt { 
	font-weight:bold;
}



.menu:link,.menu:visited,.menu:active {
 color:white;
 }
 
.headers {
	border: 1px solid black;
	background-color: green;
	color:white;
	font-style:arial;
} 

.cart {
   background-color:green;
   color:white;
   font-style:arial;
   border: 1px solid black;
   float: left;
   width: 100%;
   text-align:right;
  }
 </style>
<?php
 } 
 
 public function DisplayHeader()
 {
?>
  <h1> Fruit Shop Alexandrakis </h1>
  <h2> Μπακάλικο </h2>
<?php
  if (isset($_SESSION['valid_user'])) {
   echo "Hello ".$_SESSION['valid_user'];
  }
 }
 
 Public function DisplayDisconectButton()
 {
    if (isset($_SESSION['valid_user'])) {
     echo     "<br>";
     echo     "<button style=\"float: right;\" onclick='this.form.action=\"logout.php\";'> ";
     echo          "Αποσύνδεση";
     echo     "</button> ";  
    }
 }
 
 Public function DisplayUpdateProfileButton()
 {
    if (isset($_SESSION['valid_user'])) {
   
     echo     "<button style=\"float: right;\" onclick='this.form.action=\"updateuser.php\";'> ";
     echo          "Aλλαγή Στοιχείων";
     echo     "</button> ";  
    }
 }
 Public function DisplayMenu($buttons)
 {
 if (isset($_SESSION['admin'])) {
    $buttons = array ("Ποιοι είμαστε" => "index.php",
                      "Που είμαστε" => "where.php",
                      "Φωτογραφίες" => "photos.php",
                      "Ανεβάστε φωτογραφίες" => "photouploads.php",
                      "Παραγγελίες" => "orders.php",
                      "Κατηγορίες" => "categories.php",
                      "Προϊόντα" => "selectcategory.php",
                      "Έξοδος" => "logout.php");
  
  } else if (!isset($_SESSION['valid_user'])) {
   $buttons = array ("Ποιοι είμαστε" => "index.php",
                     "Που είμαστε" => "where.php",
                     "Φωτογραφίες" => "photos.php",
                     "Επικοινωνία" => "contactus.php",
                     "� ροϊόντα" => "selectcategory.php",
                     "Νέος χρήστης" => "newuser.php",
                     "Είσοδος" => "login.php");
  } else if (isset($_SESSION['valid_user'])){
   $buttons = array ("Ποιοι είμαστε" => "index.php",
                            "Που είμαστε" => "where.php",
                            "Φωτογραφίες" => "photos.php",
                            "Επικοινωνία" => "contactus.php",
                            "Παραγγελία" => "selectcategory.php",
                            "Οι Παραγγελίες μου" => "orders.php",
                            "Το καλάθι μου" => "mycart.php",
                            "Αλλαγή στοιχείων" => "updateuser.php",
                            "Αποσύνδεση" => "logout.php");
   } 
  echo "<table border= \"1px\"  width=\"100%\" height=\"5%\" >\n";
  echo "<tr>\n";
  $width = 100/count($buttons);
  while (list($name, $url) = each($buttons))
  {
    $this ->DisplayButton($width, $name, $url,
    !$this->IsURLCurrentPage($url));
  }
  echo "</tr>\n";
  echo "</table>\n";
 
  
 
 }
 
 public function IsURLCurrentPage($url)
 {
   if(strpos($_SERVER['PHP_SELF'], $url)==false)
   {
     return false;
   }
   else
   {
   return true;
   }
 }
 
 public function DisplayButton($width,$name,$url,$active = false)
 {
  if ($active) {
    echo "<td width = \"".$width."%\"  bgcolor=\"green\">
    <a class=\"menu\" href=\"".$url."\">".$name.
    "</td>";
   } else {
    echo "<td width=\"".$width."%\"  bgcolor=\"white\" fgcolor=\"green\" 
    >".$name." </td>";
   }
     
 }
 
 public function DisplayFooter()
 {
?>

 <div class="Footer"> 
   Web site created by Alexandrakis Alexandros 
   <br>
   Start - Rethimno 04/06/2013
   <br>
   End - Zografou 07/07/2013
 </div>

<?php
  
 }
 
 public function AddToCart($item, $qty) 
 {
      if (!isset($_SESSION['cart']))
      {
          $_SESSION['summary'] = 0;
          $_SESSION['cart'] = array();
          
      }
      $_SESSION['cart'][$item]=$qty;
      
      $_SESSION['summary'] = 0;
      while (list($item, $qty) = each($_SESSION['cart'])){
          $itemrecord = $this->GetItemRecord($item);
          $_SESSION['summary']  = $_SESSION['summary'] + ($itemrecord['price'] * $qty);
      }
 }

 public function GetItemRecord($item) {
    $db = new mysqli($this->hostname, $this->user_name, $this->user_password, $this->dbname);
      if (mysqli_connect_errno()) {
          echo "Η συνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ δοκιμάστε αργότερα.";
          exit;
      } else {
         $selectQ = "select * from  items where itemid = '".$item."'";
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($selectQ);
         $row = mysqli_fetch_assoc($result);
         $db->close();
         if ($row) {
          $itemrecord = array("descr" => $row['descr'], 
                              "price" => $row['price'],
                              "mm" => $row['mm']) ;
           return $itemrecord;
         }
      }   
 }
 
 
 
 Public function DisplaySummary(){
   if (isset($_SESSION['summary'])) {

    echo "<div class=\"cart\"  >";
    echo "Συνολική αξία καλαθιού: ".$_SESSION['summary'];
    echo "<img src=\"".$this->path."/buttons/cart1.gif\" align=\"right\"/>";
    echo "</div>";    
   }  
 }
 
 
  public function RemoveFromCart($item) 
 {
      if (isset($_SESSION['cart'][$item]))
      {
          $itemrecord = $this->GetItemRecord($item);
          $_SESSION['summary'] = $_SESSION['summary'] - ($itemrecord['price'] * $_SESSION['cart'][$item]);    
          unset($_SESSION['cart'][$item]);
      }
      
      if (empty($_SESSION['cart'])){
       unset($_SESSION['cart']);
       unset($_SESSION['summary']);
      }
       
 }

 public function isselected($value1, $value2)
 {
   if ($value1==$value2){
      return "Selected";
   } else {
      return "";
   }
 }
 
 public function ischecked($value1, $value2)
 {
   if ($value1==$value2){
      return "Checked";
   } else {
      return "";
   }
 }
 
 public function BuiltComboMM($mm1)
 {
    $combo = "";
       $combo = "<select name=\"mm\" > \n
                   <option name=\"tm\" value=\"Τεμάχιο\" ".$this->isselected("Τεμάχιο", $mm1)."> Τεμάχιο </option>\n
                   <option name=\"kg\" value=\"Κιλό\" ".$this->isselected("Κιλό", $mm1)."> Κιλό </option>  \n
                 </select>\n";
    return $combo;
 }
 
 public function BuiltComboCat($cat)
 {
    $db = new mysqli($this->hostname, $this->user_name, $this->user_password, $this->dbname);
    if (mysqli_connect_errno()) {
      die("Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.");
    }
    $combo = "";
    $db->query("SET CHARACTER SET 'utf8'");
    $SelectQ = "select * from  items_category order by category";
    $result = $db->query($SelectQ);
    if (!$result){
        die("Δεν μπορεί να γίνει σύνδεση στη βάση δεδομένων.");
    }
    $combo = "<select name=\"categoryid\"> \n";
    while ($row = $result->fetch_assoc()){
        $combo = $combo.
         "<option name=\"Cat".$row['categoryid']."\" value=\"".$row['categoryid']."\" ".
               $this->isselected($row['categoryid'], $cat)."> ".$row['category']." </option>\n";
    }
    $combo = $combo."</select>\n";
    return $combo;    
 }
 


public function BuiltComboPhotos($photo)
 {
  $Directory = "/home/vhosts/aalexandrakis.freevar.com/fruit-e-shop/productimg/";
  /*$Directory = "C:/wamp/www/fruit-e-shop/productimg/";*/
  
  $Dir_Photos =  glob($Directory . "{*.jpg,*.JPG,*.gif}", GLOB_BRACE);
  $ImageCount=0;   
  $combo = "";
  $combo = "<select name=\"photo\"> \n";
    foreach($Dir_Photos as $image){
        $path_parts = pathinfo($image);
        $imagestr = $path_parts['filename'].".".$path_parts['extension'];
        $ImageCount = $ImageCount+1;
        $combo = $combo.
         "<option name=\"img".$ImageCount."\" value=\"".$imagestr."\" ".
               $this->isselected($imagestr, $photo)."> ".$imagestr." </option>\n";
    }  
    
    $combo = $combo."</select>\n";
    return $combo;    
 }
 
}
?> 
 
<?php
Class Page
{
  
 public $content;
 public $title="Fruit Shop Alexandrakis ";
 public $buttons = array ();
 public $dbname = "";
 public $hostname = "";
 public $user_name = "";
 public $user_password = "";
 public $path="";
 public $SetBodyOnKeyPress = "";
 public $SetJsFile = "";
 public $bussiness_email="";
 public $notify_url = "";
 public $error_login_message="";
 public $email_subject="Fruit Shop Alexandrakis";
 public $email_headers="support@FruitshopAlexandrakis.com";
 public $error_random_item_message = "";
 public $DisplayRandomItems = "False";

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


 function __construct() {
   $this->LogInOutScript();
 }
 public function __set($name, $value)
 {
   $this->$name = $value;
 }


 public function Set_Path() {
   $this->Set_Variables();
   $this->path =  "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
//when index.php file is on a folder like root/fruit-e-shop we need this if
   if (!strpos($this->path, 'fruit-e-shop')) {
       $this->path .='fruit-e-shop';
   }
 }

 public function Set_Variables() {
  $this->dbname = getenv('FRUITSHOP_DB_NAME');
  $this->hostname = getenv('FRUITSHOP_DB_IP');
  $this->user_name = getenv('FRUITSHOP_DB_USERNAME');
  $this->user_password = getenv('FRUITSHOP_DB_PASSWORD');
  $this->bussiness_email=getenv('HOTMAIL');
  $this->notify_url = getenv('FRUITSHOP_URL').'/paymentok.php';

 }

 public function Display()
 {
  echo "<html>\n";
  echo "<head>\n";
  if ($this->SetJsFile != ""){
     echo "<SCRIPT language=\"JavaScript\" src=\"".$this->SetJsFile."\"></SCRIPT>\n";
  }
  echo "<SCRIPT language=\"JavaScript\" src=\"GlobalLogin.js\"></SCRIPT>\n";
  echo " <!-- Bootstrap core CSS -->
    <link href=\"../bootstrap-3.1.1-dist/css/bootstrap.css\" rel=\"stylesheet\" media=\"screen\">
    <link href=\"../bootstrap-3.1.1-dist/css/bootswatch.min.css\" rel=\"stylesheet\">";

  $this->DisplayTitle();
//   $this->DisplayStyles();
  //echo "</head>\n";
  if ($this->SetBodyOnKeyPress=="") {
     echo "</head>\n<body role = \"document\">\n";
  }  else {
     echo "</head>\n<body role = \"document\" onKeyPress=\"".$this->SetBodyOnKeyPress."\">\n";
     echo "<div class=\"container\" role=\"main\">";
  }
  $this->DisplayHeader();
  $this->DisplayMenu($this->buttons);
  $this->DisplayLoginSection();
//   $this->DisplaySummary();
  /*$this->DisplayDisconectButton();
  $this->DisplayUpdateProfileButton();*/
  if ($this->DisplayRandomItems=="True"){
	$this->SelectRandomItems();
  }

  echo $this->content;
  $this->DisplayFooter();
  echo "</body>\n</html>\n";
  echo "<!-- Bootstrap core JavaScript\n
  ================================================== -->\n
  <!-- Placed at the end of the document so the pages load faster -->\n
  <script src=\"https://code.jquery.com/jquery-1.10.2.min.js\"></script>
  <script src=\"../bootstrap-3.1.1-dist/js/bootstrap.min.js\"></script>
  <script src=\"../bootstrap-3.1.1-dist/js/bootswatch.js\"></script>";
  //echo "</html>\n";
 }

 public Function DisplayTitle()
 {
   echo "<title>".$this->title."</title>";
 }

 public function DisplayStyles()
 {
?>
 <style>

h2 {
	color:green;
	text-align:center;
	float:center;
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

.categorylink:link,.categorylink:visited,.categorylink:active {
 color:black;
 text-decoration:none;
 }

.itemlink:link,.itemlink:visited,.itemlink:active {
 color:green;
 text-decoration:none;
 }

.categorytable {
          border: 1px solid black;
}

.headers {
	border: 1px solid black;
	background-color: green;
	color:white;
	font-style:arial;
}


.pagetd {
          border: 1px solid black;
          background-color:green;
}

.pagelink:link,.pagelink:visited,.pagelink:active {
 color:black;
 text-decoration:none;
 }

.RandomItem {
	border: 3px groove green;
	color:black;
	font-style:arial;
}

.RandomImage {
     margin-left: 1px;
     margin-right: 1px;
     margin-top: 1px;
     margin-bottom: 5px;
     width: 100px;
     height: 80px;
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
  <!-- <h1> Fruit Shop Alexandrakis </h1>
  <h2> Μπακάλικο </h2> -->
  <a href="downloadapk.php">  Click here to download android application Fruit-e-shop  </a>
  <br>
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
 Public function DisplayLoginSection(){
       $this->Set_Path();
       if (!isset($_SESSION['valid_user']) && !isset($_SESSION['admin'])){
       	if ($this->error_login_message!=""){
       		echo     "<div class=\"alert alert-danger\">".$this->error_login_message."</div>\n";
       	}
	       echo "<form name='login'  method='post'>\n";
	       echo     "<div class=\"row\" >\n";
	       echo     "<div class=\"col-lg-12\">";
	       echo       "<span>Email</span>\n";
	       echo	     "<input type=\"text\" name=\"loginemail\" size=\"50\" maxlength=\"50\" />\n";
	       echo	     "<span> Κωδικός </span>\n";
	       echo	     "<input type=\"password\" name=\"loginpassword\" size=\"20\" maxlength=\"20\" />\n";
	       echo	     "<input type=\"button\" class=\"btn btn-primary\" name=\"loginbtn\" Value=\"Εισοδος\" onClick=\"GlobalCheckLoginData()\"/>\n";
	       echo	     "<input type=\"button\" class=\"btn btn-primary\" name=\"forgotpassword\"  Value=\"Ξέχασα τον κωδικό μου\" onClick=\"GlobalForgotPasswordScript()\"/>\n";
	       echo     "</div>\n";
	       echo     "</div>\n";
	       echo "</form>\n";
    } else {
               echo "<form name='logout'  method='post'>\n";
	       echo   "<div class=\"row\">\n";
	       echo     "<div class=\"col-lg-12\">";
	       echo 	"<input type=\"hidden\" name=\"logouthidden\"/>\n";
	       echo     "<input type=\"button\" class=\"btn btn-danger\" name=\"logoutbtn\" Value=\"Αποσύνδεση\" onClick=\"LogOutScript()\"/>\n";
	       echo   "</div>\n";
	       echo   "</div>\n";
	       echo "</form>\n";
    }
    echo "<br>\n";
    echo "<br>\n";
    echo "<br>\n";
 }

 Public function LogInOutScript(){
      if ((isset($_POST['loginemail'])) && (isset($_POST['loginpassword']))
		&& $_POST['loginemail']!='' && $_POST['loginpassword']!='') {
	    $db = new mysqli($this->hostname, $this->user_name, $this->user_password, $this->dbname);
	      if (mysqli_connect_errno()) {
	          $this->error_login_message = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
	      } else {
	         $SelectQ = "select * from  customers where email=\"".$_POST['loginemail']."\" and password=\"".
	         sha1($_POST['loginpassword'])."\"";
	          $result = $db->query($SelectQ);
	          if ($result->num_rows <= 0 ) {
	            $this->error_login_message = "Το email ή ο κωδικός πρόσβασης είναι λάθος. Προσπαθήστε ξανά.";
	            $db->close();
                  } else {
	              $row = $result->fetch_assoc();
	              if ($row['admin'] == 1){
	                $_SESSION['admin']=1;
	              }
	              $_SESSION['valid_user'] = $_POST['loginemail'];
	              $db->close();
                  }
              }
          }
     if (isset($_POST['logouthidden'])){
        unset($_SESSION['valid_user']);
        unset($_SESSION['admin']);
	    header('Location: http://www.aalexandrakis.freevar.com/fruit-e-shop');
//         header('Location: index.php');
     }
 }


 Public function SelectRandomItems(){
	  $this->error_random_item_message="";
          if ($this->DisplayRandomItems == "True") {
	    $db = new mysqli($this->hostname, $this->user_name, $this->user_password, $this->dbname);
	      if (mysqli_connect_errno()) {
	          $this->error_random_items_message = "Η σύνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ προσπαθήστε αργότερα.";
	      } else {
//	         $SelectQ = "select * from  items where display=1 and price>0 and photo<>''";
	         $SelectQ = "select * from  items where display=1 and price>0 ";
	         $db->query("SET CHARACTER SET 'utf8'");
	          $result = $db->query($SelectQ);
	          if ($result->num_rows <= 0 ) {
	            $this->error_random_item_message = "Δεν βρέθηκαν προϊόντα";
	            $db->close();
                  } else {
                      $ArrayCounter = 0;
		      $items_array = array();
	              while ($row = $result->fetch_assoc()){
			$items_array[++$ArrayCounter] = $row;
		      }
	              $db->close();
		      echo "<br>";
		      echo "<table width='100%'>";
		      echo "<tr>";
		      if ($ArrayCounter < 5){
                          $repeats = $ArrayCounter;
                      } else {
                          $repeats = 5;
                      }
		      for ($i=0;$i<$repeats;++$i){
		        $Random_Item = rand(1, $ArrayCounter);
                      	while(isset($random_item_array[$Random_Item])){
			      $Random_Item = rand(1, $ArrayCounter);
			}
                        $random_item_array[$Random_Item]=$items_array[$Random_Item];
			$this->DisplayRandomItem($random_item_array[$Random_Item]);
		      }
                      echo "</tr>";
		      echo "</table>";
		      echo "<br>";

                  }
              }


          }
 }


 Public function DisplayRandomItem($Random_Item){

    echo "<td class='RandomItem' width='20%'>";
    echo "<div height='100%' width='100%'>";
    echo "<img class='RandomImage' src='".$this->path."/productimg/".$Random_Item['photo']."' alt='Item Photo' />";
    echo "<br>";
    echo "<a href='itemdetails.php?itemid=".$Random_Item['itemid']."'>".$Random_Item['descr']."</a>";
    echo "<br>";
    echo $Random_Item['price'];
    echo "</div>";
    echo "</td>";
 }

 Public function DisplayMenu($buttons)
 {
 	$cartSize = "";
 if (isset($_SESSION['cart'])){
 	$cartSize = "(".count($_SESSION['cart']).")";
 }

 if (isset($_SESSION['admin'])) {
    $buttons = array ("Ποιοι είμαστε" => "who.php",
                      "Που είμαστε" => "where.php",
                      "Φωτογραφίες" => "photos.php",
                      "Ανεβάστε φωτογραφίες" => "photouploads.php",
                      "Παραγγελίες" => "orders.php",
                      "Κατηγορίες" => "categories.php",
                      "Προϊόντα" => "index.php",
                      "Πελάτες" => "ViewCustomers.php",
                      "Αλλαγή στοιχείων" => "updateuser.php");
//                      "Έξοδος" => "logout.php");

  } else if (!isset($_SESSION['valid_user'])) {

   $buttons = array ("Ποιοι είμαστε" => "who.php",
                     "Που είμαστε" => "where.php",
                     "Φωτογραφίες" => "photos.php",
                     "Επικοινωνία" => "contactus.php",
                     "Παραγγελία" => "index.php",
                     "Το καλάθι μου".$cartSize => "mycart.php",
                     "Νέος χρήστης" => "newuser.php");
//                     "Είσοδος" => "login.php");
  } else if (isset($_SESSION['valid_user'])){
   $buttons = array ("Ποιοι είμαστε" => "who.php",
                            "Που είμαστε" => "where.php",
                            "Φωτογραφίες" => "photos.php",
                            "Επικοινωνία" => "contactus.php",
                            "Παραγγελία" => "index.php",
                            "Οι Παραγγελίες μου" => "orders.php",
                            "Το καλάθι μου".$cartSize => "mycart.php",
                            "Αλλαγή στοιχείων" => "updateuser.php");
//                            "Αποσύνδεση" => "logout.php");
   }
//   echo "<table border= \"1px\"  width=\"100%\" height=\"5%\" >\n";
//   echo "<tr>\n";
  echo " <div class=\"navbar navbar-inverse\">\n
  		 <div class=\"container\">\n
          <div class=\"navbar-header\">\n
            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
              <span class=\"sr-only\">Toggle navigation</span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"#\">"."Fruit Shop Alexandrakis"."</a>\n
          </div>\n
  		 <div class=\"navbar-collapse collapse\">
         <ul class=\"nav navbar-nav\">";

  $width = 100/count($buttons);
  while (list($name, $url) = each($buttons))
  {
    $this ->DisplayButton($width, $name, $url,
    !$this->IsURLCurrentPage($url));
  }
//   echo "</tr>\n";
//   echo "</table>\n";
  echo "</ul> \n
  </div><!--/.nav-collapse -->
  </div>\n</div>";



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
  	echo "<li class=\"active\"><a href=".$url.">".$name."</a></li>";
//     echo "<td width = \"".$width."%\"  bgcolor=\"green\">
//     <a class=\"menu\" href=\"".$url."\">".$name."</a>".
//     "</td>\n";
   } else {
//     echo "<td width=\"".$width."%\"  bgcolor=\"white\" fgcolor=\"green\"
//     >".$name." </td>\n";
   	echo "<li><a href=".$url.">".$name."</a></li>";
   }

 }

 public function DisplayFooter()
 {
?>
		<div class="row">
          <div class="col-lg-12">
            <div class="bs-component">
              <div class="well">
                Web site created by Alexandrakis Alexandros
              </div>
            </div>
          </div>
          </div>


     <br>
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
      reset($_SESSION['cart']);
      while (list($item, $qty) = each($_SESSION['cart'])){
          $itemrecord = $this->GetItemRecord($item);
          $amount_value = $itemrecord['price'] * $qty;
          //echo "<br> summary before".$_SESSION['summary'];
          $_SESSION['summary']  = $_SESSION['summary'] + $amount_value;
          //echo "ITEM ".$item."<br> Qty ".$qty."<br> price ".$itemrecord['price']."<br> amount_value ".$amount_value;
          //echo "<br> summary after".$_SESSION['summary'];
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

 public function GetAdminEmails() {
    $email_list = "";
    $db = new mysqli($this->hostname, $this->user_name, $this->user_password, $this->dbname);
      if (mysqli_connect_errno()) {
          return $email_list;
      } else {
         $selectQ = "select * from  customers where admin=1";
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($selectQ);
         while ($row = mysqli_fetch_assoc($result)) {
           if ($email_list != ""){
               $email_list = $email_list.",".$row['email'];
           } else {
               $email_list = $row['email'];
           }
         }
         $db->close();
         return $email_list;
      }
 }


 Public function DisplaySummary(){
   $this->Set_Path();
   if (isset($_SESSION['summary'])) {

    echo "<div class=\"cart\"  >";
    echo "Συνολική αξία καλαθιού: ".$_SESSION['summary'];
    echo "<img src=\"".$this->path."/buttons/cart.GIF\" align=\"right\"/>";
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
       $combo = "<select class=\"form-control\" name=\"mm\" > \n
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
    $combo = "<select class=\"form-control\" name=\"categoryid\"> \n";
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
  //$Directory = "/home/vhosts/aalexandrakis.freevar.com/fruit-e-shop/productimg/";
  /*$Directory = "C:/wamp/www/fruit-e-shop/productimg/";*/
    $Directory = __DIR__."/productimg/";
  //$Dir_Photos =  glob($Directory . "{*.jpg,*.JPG,*.gif}", GLOB_BRACE);
  $Dir_Photos =  glob($Directory."{*.*}", GLOB_BRACE);
  $ImageCount=0;
  $combo = "";
  $combo = "<select class=\"form-control\" name=\"photo\"> \n";
  $combo = $combo.
   "<option name=\"none\" value='' ".
               $this->isselected("", $photo)."> "."  "." </option>\n";
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

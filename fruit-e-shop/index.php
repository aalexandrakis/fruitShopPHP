    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<?php 
  session_start();
  include ('page.inc');
  $homepage=new Page();
  $homepage->Set_Path();
  
  if (isset($_SESSION['admin'])){
      $linkitemto="item.php?itemid=";
      $homepage->content = "<a href='item.php'>Εισαγωγή νέου είδους</a>";
  } else {
      $linkitemto="itemdetails.php?itemid=";
  }
  if (isset($_POST['catid'])){
     $catid = $_POST['catid'];
  }
  if ((!isset($_POST['pagenum'])) or $_POST['pagenum']==1){
     $offset=0;
  } else {
     $offset = (($_POST['pagenum'] - 1) * 20)  ;
  }

  
  
  $db = new mysqli($homepage->hostname, $homepage->user_name, $homepage->user_password, $homepage->dbname);
      if (mysqli_connect_errno()) {
          echo "Η συνδεση στη βάση δεδομένων δεν είναι εφικτή. Παρακαλώ δοκιμάστε αργότερα.";
          exit;
      } else {
         $selectQ = "select * from  items_category order by category";
         $db->query("SET CHARACTER SET 'utf8'");
         $result = $db->query($selectQ);
      }  


 function getItemsCount($db, $catid){
         if(!isset($_SESSION['admin'])){
	      	 $selectQ = "select count(*) from  items where display=1 and price>0 and categoryid=".$catid;
         } else {
                 $selectQ = "select count(*) from  items where categoryid=".$catid;
         }
         $db->query("SET CHARACTER SET 'utf8'");
         $result_count=$db->query($selectQ);
         if (!$result_count){
            die($selectQ);
         }
         if ($row = mysqli_fetch_row($result_count)){
             return $row[0];
         }
 }


 function getNextItems($db, $catid, $offset){
         if(!isset($_SESSION['admin'])){
         	$selectQ = "select * from  items where display=1 and price>0 and categoryid=".$catid." order by categoryid, descr limit ".$offset.", 20";
         } else {
		$selectQ = "select * from  items where categoryid=".$catid." order by categoryid, descr limit ".$offset.", 20";
         }
         $db->query("SET CHARACTER SET 'utf8'");
         $result_items=$db->query($selectQ);
         if(!$result_items){
            die($selectQ);
         }
         return $result_items;
  }                 
  
  $homepage->content .= 
   "<form name='items' method=\"post\">\n
    <input type='hidden' name='pagenum'/> 
    <!--<div name='maindiv' id='maindiv' style='height:"."@@height@@"."px;padding:1px;'>-->
    <div class=\"row\">\n
  	<div class=\"col-xs-3\" style='float:left'>\n
  	<div class=\"list-group\">";
       
    while ($row = mysqli_fetch_assoc($result)) {
         if (!isset($catid)){
             $catid=$row['categoryid'];
         } 
         if ($row['categoryid'] == $catid){
           $homepage->content .= 
//            "<tr><td bgcolor='white'>".$row['category']."</td></tr>\n";
           "<a class=\"list-group-item active\" href=\"#\">".$row['category']."</a>"; 
         } else {
           $homepage->content =  $homepage->content.
           "<a class='list-group-item' href='#' onClick='document.items.catid.value=".$row['categoryid'].";
                                                     document.items.pagenum.value=1;
				     	             document.items.submit();'>"
	   .$row['category']."</a>\n"; 
         } 
    }
   //$db->close();
   $homepage->content .= "<input type='hidden' name='catid' value='".$catid."'/>";

   $result_items=getNextItems($db, $catid, $offset);
   $homepage->content .=
   "</div>\n</div>\n";

   
//    "<div width='80%'>\n".
   //"<table height='100%' width='100%' >\n";
//      "<table height='100%' width='80%' >\n";
//        $homepage->content .="<tr>\n";
   	   $homepage->content .="<div class=\"col-xs-9\">\n";
       $counter = 0;
       $filledrows = 1;
       while ($row_item = mysqli_fetch_assoc($result_items)){
//            if ($counter==4){
               $counter=0;
               ++$filledrows;
               $homepage->content .="<div class=\"col-xs-3\" style='height:40%;'>\n";
               $homepage->content .= "<img src='".$homepage->path."/productimg/".$row_item['photo']."' alt='Item Photo' style=\"width: 200px; height: 200px;\" data-src=\"holder.js/200x200\" class=\"img-thumbnail\" alt=\"200x200\">";
               $homepage->content .="<a href='".$linkitemto.$row_item['itemid']."'>".$row_item['itemid']."-".$row_item['descr']."</a>" ;
               $homepage->content .="<br>".$row_item['price']." &euro;";
               $homepage->content .="</div>\n";
//            }
           ++$counter;
        }   
//                $homepage->content .="</tr>\n";
// 	       $homepage->content .="<tr>\n";
//            }
//            $homepage->content .="<td width='25%' height='200px' style='border: 1px solid lightgreen;'>\n";
//            $homepage->content .="<div>\n";
//            $homepage->content .="<img src='".$homepage->path."/productimg/".$row_item['photo']."' alt='Item Photo' width='120' height='120'/>";
//            $homepage->content .="<br>";
//            $homepage->content .="<a class='itemlink' href='".$linkitemto.$row_item['itemid']."'>".$row_item['itemid']."-".$row_item['descr']."</a>" ;
//            $homepage->content .="<br>";
//            $homepage->content .=$row_item['price']." &euro;";
//            $homepage->content .="</div>\n";
//            $homepage->content .="</td>\n";
//            ++$counter;
//        }
//        if ($filledrows > 1) {
//           $divheight = $filledrows * 200;
//        } else {
//           $divheight = 300;
//        }
// //        $homepage->content .="</tr>\n";
//        $homepage->content .=
//      "</div>\n". 
    $homepage->content .="</div>\n";
    $homepage->content .="</div>\n";
//     "<br>";
       
      $pages = ceil((getItemsCount($db, $catid) / 20)); 
//       $homepage->content .= 
//       "<div width='100%' style='clear:both;'>
//          <table style='margin: 0 auto;'>
//            <tr>";
      $homepage->content .="<div class='page-header' style='clear:both;'>";
      $homepage->content .="Σελίδα:";
      for ($i=1;$i<=$pages;++$i){
         if (isset($_POST['pagenum']) && $i != $_POST['pagenum']){ 
            $homepage->content .= "<input type='button' class='btn btn-xs btn-primary' href='#' value='".$i."' onClick='document.items.pagenum.value=".$i.";".
                                                                                           "document.items.submit();'/>";
         } else {
            $homepage->content .= " ".$i." ";
         }
      }
      $homepage->content .="<div/>";
//       $homepage->content .=
//           "</tr>
//          </table> 
//        </div>";
    
   $homepage->content .=
     "</form>\n<br>";

   $db->close();
//   $homepage->content = str_replace("@@height@@", $divheight, $homepage->content);
  $homepage->Display();  

?>

 
   
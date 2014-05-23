<?php


$ch = curl_init();
$clientId = "AUl3SBB9GnH14J1_XZe6BbIBB8bMeSn9u_Zf14CeTQQyGnF57g7o4wI0cpFu";
$secret = "EEDz6hBBk-yDwEzIqwRjthwfWNqjUajj8HmLtr1Rwu5R5fpkBLOtnNNaEin7";

$Directory = __DIR__."/";
echo $Directory;
//$Dir_files =  glob($Directory."{*.*}", GLOB_BRACE);
$Dir_files =  glob($Directory, GLOB_BRACE);

foreach ($Dir_files as $file){
   echo "<br>";
   echo $file;
}

//require DIR . '/vendor/autoload.php';
use PayPal\Rest\ApiContext;  
use PayPal\Auth\OAuthTokenCredential;  
//+use PayPal\Auth\OAuthTokenCredential; 
$oauthCredential = new OauthTokenCredential($clientID, $secret);
$accessToken     = $oauthCredential->getAccessToken(array('mode' => 'sandbox'));
echo $accesToken;

	
curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

$result = curl_exec($ch);

if(empty($result))die("Error: No response.");
else
{
    $json = json_decode($result);
    print_r($json->access_token);
    echo "<br>";
    print_r($json->token_type);
    echo "<br>";
    print_r($json->app_id);
    echo "<br>";
    print_r($json->scope);
    echo "<br>";
    print_r($json->expires_in);
 }

curl_close($ch);
echo "<br>";
$payment = curl_init(); 
$headerarray = Array("Content-Type"=>"application/json",
                     "Authorization"=>"Bearer ".$json->access_token);

$redirect_urls = Array ("return_url"=>"http://www.aalexandrakis.freevar.com/paymentok.php",
                        "cancel_url"=>"http://www.aalexandrakis.freevar.com/paymentcancel.php");    
echo "<br>";
echo "ok";
echo "<br>";
$payer = Array ("payment_method" => "paypal");
$amount = Array ("total"=>"7.47",
                 "currency"=>"USD");
$transactions = Array ("amount"=>$amount,
                       "description"=>"This is the payment transaction description.");
  
$postdata = Array("intent"=>"sale",
                  "redirect_urls"=>$redirect_urls,
                  "payer"=>$payer,
                  "transactions"=>$transactions);

echo "<br>";
echo "postdata";
$json_post = json_encode($postdata);
echo $json_post;
echo "<br>";
//$postdata = "{
//  intent:sale,
//  redirect_urls:{
//    return_url:http://www.aalexandrakis.freevar.com/paymentok,
//    cancel_url:http://www.aalexandrakis.freevar.com/paymentok
// },
//  payer:{
//    payment_method:paypal
//  },
//  transactions:[
//    {
//      amount:{
//        total:7.47,
//        currency:USD
//      },
//      description:This is the payment transaction description.
//    }
//  ]
//}";
echo "<br>";
//echo $postdata
//$json_headers = json_encode($headerarray);
//echo $json_headers;
curl_setopt($payment, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payment");
curl_setopt($payment, CURLOPT_HEADER, $headerarray);
curl_setopt($payment, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($payment, CURLOPT_POST, true);
curl_setopt($payment, CURLOPT_RETURNTRANSFER, true); 
//curl_setopt($payment, CURLOPT_USERPWD, $clientId.":".$secret);
curl_setopt($payment, CURLOPT_POSTFIELDS, $json_post);
$result = curl_exec($ch);
echo $result;
curl_close($payment);
?>
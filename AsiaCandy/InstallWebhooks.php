<?php 
// echo "<h1>working</h1>";

include_once("./StoreDetails.php");

$postdata='{
    "scope": "store/order/created",
    "destination": "'.$DomainName.'BigCommerceSMS/'.$FolderName.'/ordersms.php",
    "is_active": true,
    "events_history_enabled": true,
    "headers": {
      "custom": "string"
    }
  }';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.bigcommerce.com/stores/".$StoreHash."/v3/hooks");
// curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept:application/json',
    'Content-Type:application/json',
    "X-Auth-Token:{$AuthToken}"
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_HEADER, true); 
$server_output = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close ($ch);
echo $server_output."\n";
if($httpcode=="200"){
echo "Order Created webhook installed \n";
}else {
  echo "Error installing webhooks \n";
}

?>
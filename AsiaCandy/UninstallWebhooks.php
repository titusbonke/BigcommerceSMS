<?php 
// echo "<h1>working</h1>";

// $filename = "./api.txt";
// $fp = fopen($filename, "r");

// $content = explode("\n", file_get_contents($filename));
// fclose($fp);
// print_r($content);

include_once("./StoreDetails.php");

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.bigcommerce.com/stores/".$StoreHash."/v3/hooks");
// curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept:application/json',
    'Content-Type:application/json',
    'X-Auth-Token:'.$AuthToken
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_NOBODY, false);
$server_output = curl_exec($ch);
curl_close ($ch);
echo $server_output;

$Data=json_decode($server_output)->data;
// print_r($Data);
echo "\n Total available webhooks : ".count($Data);
$count = 0;

foreach ($Data as $item){
    
    $HookId=$item->id;
    echo $HookId;
    $ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.bigcommerce.com/stores/".$StoreHash."/v3/hooks/".$HookId);
// curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept:application/json',
    'Content-Type:application/json',
    'X-Auth-Token:'.$AuthToken,
    'webhook_id:'.$HookId
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
// curl_setopt($ch, CURLOPT_NOBODY, false);
curl_setopt($ch, CURLOPT_HEADER, true); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$server_output = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close ($ch);
echo "\n".$server_output;
if($httpcode=="200"){
  $count++;
}

}

echo "\n Total Uninstalled webhooks : ".$count;








?>
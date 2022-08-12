<?php
 $data=file_get_contents('php://input');
 $WebhookDetails=json_decode($data,true);
 include_once("./StoreDetails.php");

//  $message="The order id ".$orders['id']." has been ordered on your shopiy account ".$orders['email']." on for rs ".$orders['total_price'].".";
    // print_r($WebhookDetails);

    $OrderId=$WebhookDetails["data"]["id"];
    // $OrderId=102;
echo "\n Order Id: ".$OrderId."\n";

$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.bigcommerce.com/stores/{$StoreHash}/v2/orders/".$OrderId,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: application/json",
    "Content-Type: application/json",
    "X-Auth-Token: {$AuthToken}"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo "Order Details retrieved successfully Id-".$OrderId."\n";
}

$Data=json_decode($response);
    
    $email1=$Data->billing_address->email;
    $name=$Data->billing_address->first_name." ".$Data->billing_address->last_name;
    $phnumber=$Data->billing_address->phone;
    $total_ammount=$Data->total_inc_tax;
    $message = str_replace('{id}',$OrderId,$message);
    $message = str_replace('{email}',$email1,$message);
    $message = str_replace('{name}',$name,$message);
    $message = str_replace('{total_price}',$total_ammount,$message);
    $message = preg_replace('/\s+/','%20',$message);

if($phnumber!=""&& $phnumber!=null){
$phnumber=trim($phnumber);
$url="https://api.msg4.sathyainfo.com/sms.aspx?apikey={$apikey}&tmpid={$tmpid}&sid={$snid}&sno=98940&to={$phnumber}&msg={$message}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $server_output = curl_exec($ch);
    curl_close ($ch);
    // echo $server_output;
    // $payload = file_get_contents("https://api.cutesms24.com/sms.aspx?email=titusbonkec@gmail.com&pw=Titussurya.5&sid=SATHYA&sno=9840397985&to=9524864129&msg=what the heck");
    // echo $payload;
    echo "OutPut: ".$server_output;

}else{
    echo "Phone Number is not available";
}
 ?>
<?php
echo "url: ".$url;
// echo "outPut: ".$server_output;
?>
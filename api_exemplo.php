<?php

//$content = file_get_contents( 'https://api.tin-check.com/api.php?tk=5cfaa30350871cce6be92456c7821eb9&op=tc&ca=pt&tn=509845410' );
$content = '{"result":"valid","details":{"tin":"509845410","country":"Portugal (PT)","type":"Singular person"},"credits":{"used":1,"left":6}}';
var_dump($content);
if(strstr($content,"Legal person")) echo "É uma empresa!";
if(strstr($content,"Singular person")) echo "É uma pessoa!"
?>
<?php

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://stock-data-yahoo-finance-alternative.p.rapidapi.com/v6/finance/quote?symbols=AAPL%2CETH-USD",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: stock-data-yahoo-finance-alternative.p.rapidapi.com",
        "x-rapidapi-key: 2644fd15eemsh62cbd9f91d3b102p180455jsn3c119b46e6ed"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
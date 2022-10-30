<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://candaan-api.vercel.app/api/text/random",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',

));

$response = curl_exec($curl);
curl_close($curl);
$jokes = json_decode($response, true);


var_dump($jokes);
echo "<pre>" . print_r($jokes, true);
echo "</pre>";

echo $jokes['data'];
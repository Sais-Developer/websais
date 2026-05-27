<?php
require "../../konek/koneksi.php";
require "../../konek/function.php";


$api_url = $setting['server'] ."/sincek.php"; 
$token = $setting['token_api']; 

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url . "?token=" . $token);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10); 


$response = curl_exec($ch);

if(curl_errno($ch)){
    echo "cURL Error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

$data = json_decode($response, true);

if ($data['status']) {
    echo "✅ Token valid: " . $data['message'];
   
} else {
    echo "❌ Gagal: " . $data['message'];
}
?>

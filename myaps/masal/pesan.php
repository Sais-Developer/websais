<?php
require("../../konek/koneksi.php");
$token = "YnHMd7THBfozaQM9VHR3";

$input_number = $_POST['nowa'];
$message      = $_POST['pesan'];

$number = preg_replace('/[^0-9]/', '', $input_number);

if (substr($number, 0, 1) === "0") {
    $target = "62" . substr($number, 1);
}
else if (substr($number, 0, 2) === "62") {
    $target = $number;
}

else {
    $target = "62" . $number;
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $setting['url_api']."/send", 
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => [
        'target' => $target,
        'message' => $message,
    ],
    CURLOPT_HTTPHEADER => [
        "Authorization: $token"
    ],
));

$response = curl_exec($curl);
curl_close($curl);

// ===== Output =====
echo "Nomor tujuan: $target<br>";
echo "Respons: $response";
?>

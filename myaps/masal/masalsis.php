<?php
require("../../konek/koneksi.php");

$token   = $setting['wa_token'];
$url_api = $setting['url_api'];

function formatNumber($number) {
    $number = preg_replace('/[^0-9]/', '', $number); 
    if (substr($number, 0, 1) === "0") {
        return "62" . substr($number, 1);
    } elseif (substr($number, 0, 2) === "62") {
        return $number;
    } else {
        return "62" . $number;
    }
}

function sendWA($number, $message, $url_api, $token) {
    $target = formatNumber($number);

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url_api . "/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'target' => $target,
            'message' => $message,
        ],
        CURLOPT_HTTPHEADER => [
            "Authorization: $token"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
$pesan = $_POST['pesan'];

$stmt = $pdo->prepare("SELECT nowa FROM siswa WHERE kelas = :kelas AND nowa <> ''");
$stmt->execute(['kelas' => $kelas]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $data) {
$nowa = $data['nowa'];
$response = sendWA($nowa, $pesan, $url_api, $token);
echo "Nomor: $nowa, Response: $response\n";
sleep(1); 
}
?>

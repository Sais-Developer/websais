<?php
require("../konek/koneksi.php");
require("../konek/function.php");
require("../konek/crud.php");
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

$token   = $setting['wa_token'];
$url_api = $setting['url_api'];


$kartu = $_POST['uid'];

try {
   
    $stmt = $pdo->prepare("
        SELECT d.*, s.id_siswa, s.saldo, s.nama, s.nowa
        FROM datareg d
        LEFT JOIN siswa s ON s.id_siswa = d.idsiswa
        WHERE d.nokartu = :kartu
    ");
    $stmt->execute([':kartu' => $kartu]);
    $siswa = $stmt->fetch(PDO::FETCH_ASSOC);
    $nowa = $siswa['nowa'];
	
    if (!$siswa) {
        echo "GAGAL";
        exit;
    }

    echo "      SMK SADAM CISURUPAN       \n";
    echo "  Jalan Serang RT. 006 RW. 005  \n";
    echo "================================\n";
    echo "         CEK SALDO             \n\n";  
    echo "Nama   : " . substr($siswa['nama'], 0, 22) . "\n";
    echo "Saldo  : RP " . number_format($siswa['saldo']) . "\n";
    echo "Reff   : " . date('YmdHis') . "\n";
    echo "================================\n";
    echo "        TERIMA KASIH            \n";
    echo " Cetak pada " . date('d-m-Y H:i:s') . " \n\n";

$notif = "Nama   : " . substr($siswa['nama'], 0, 22) . "\n" . 
         "Saldo  : RP " . number_format($siswa['saldo']) . "\n" . 
         "Reff   : " . date('YmdHis');

sendWA($nowa, $notif, $url_api, $token);


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

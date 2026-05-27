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

$tgl = date('Y-m-d');
$waktu = date('H:i:s');
$kartu = $_POST['uid'];
$besar = $_POST['besar'];

try {
   
    $stmt = $pdo->prepare("
        SELECT d.*, s.id_siswa, s.saldo, s.nama, s.nowa
        FROM datareg d
        LEFT JOIN siswa s ON s.id_siswa = d.idsiswa
        WHERE d.nokartu = :kartu
    ");
    $stmt->execute([':kartu' => $kartu]);
    $siswa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$siswa) {
        echo "GAGAL";
        exit;
    }
    $nowa = $siswa['nowa'];
    $saldoawal = $siswa['saldo'];
    $ids = $siswa['id_siswa'];
    $tambah = $saldoawal + $besar;

    $stmtUpdate = $pdo->prepare("UPDATE siswa SET saldo = :saldo WHERE id_siswa = :ids");
    $stmtUpdate->execute([':saldo' => $tambah, ':ids' => $ids]);

    $stmtInsert = $pdo->prepare("INSERT INTO saldo(tanggal, jam, idsiswa, debet, kredit) VALUES(:tgl, :waktu, :ids, :debet, 0)");
    $stmtInsert->execute([
        ':tgl' => $tgl,
        ':waktu' => $waktu,
        ':ids' => $ids,
        ':debet' => $besar
    ]);

    echo "      SMK SADAM CISURUPAN       \n";
    echo "  Jalan Serang RT. 006 RW. 005  \n";
    echo "================================\n";
    echo "         TOP UP SALDO           \n\n";  
    echo "Nama   : " . substr($siswa['nama'], 0, 22) . "\n";
    echo "Awal   : RP " . number_format($saldoawal) . "\n";
    echo "Top Up : RP " . number_format($besar) . "\n";
    echo "Saldo  : RP " . number_format($tambah) . "\n";
    echo "Reff   : " . date('YmdHis') . "\n";
    echo "================================\n";
    echo "        TERIMA KASIH            \n";
    echo " Cetak pada " . date('d-m-Y H:i:s') . " \n\n";

$notif = "Nama   : " . substr($siswa['nama'], 0, 22) . "\n" . 
         "Awal   : RP " . number_format($saldoawal) . "\n" . 
         "Top Up : RP " . number_format($besar) . "\n" . 
         "Saldo  : RP " . number_format($tambah) . "\n" . 
         "Reff   : " . date('YmdHis') . "\n" . 
         "Terima kasih telah melakukan transaksi!";

sendWA($nowa, $notif, $url_api, $token);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

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

    $ids = $siswa['id_siswa'];
    $saldo = $siswa['saldo'];
    $nowa = $siswa['nowa'];
    if ($saldo < $besar) {
        echo "KURANG";
        exit;
    }

    $saldomu = $saldo - $besar;

    $stmtUpdate = $pdo->prepare("UPDATE siswa SET saldo = :saldo WHERE id_siswa = :ids");
    $stmtUpdate->execute([':saldo' => $saldomu, ':ids' => $ids]);

    $stmtInsert = $pdo->prepare("INSERT INTO saldo(tanggal, jam, idsiswa, debet, kredit) VALUES(:tgl, :waktu, :ids, 0, :besar)");
    $stmtInsert->execute([
        ':tgl' => $tgl,
        ':waktu' => $waktu,
        ':ids' => $ids,
        ':besar' => $besar
    ]);

    $nama = (strlen($siswa['nama']) > 20) ? substr($siswa['nama'], 0, 20) . " .." : $siswa['nama'];

    $bulane = fetch('bulan', ['bln' => $bulan]); 

    echo "      SMK SADAM CISURUPAN       \n";
    echo "  Jalan Serang RT. 006 RW. 005  \n";
    echo "================================\n";
    echo "  STRUK BUKTI PENARIKAN SALDO   \n\n";  
    echo "Bulan  : " . $bulane['ket'] . " " . $tahun . "\n"; 
    echo "Nama   : " . $nama . "\n";
    echo "Tgl Trx: " . date('d-m-Y', strtotime($tgl)) . "\n";
    echo "Besar  : RP. " . number_format($besar) . "\n";
    echo "Saldo  : RP. " . number_format($saldomu) . "\n";
    echo "Reff   : " . $data['bukti'] . "\n"; 
    echo "================================\n";
    echo "        TERIMA KASIH            \n";
    echo " Cetak pada " . date('d-m-Y H:i:s') . " \n";

$notif = "Bulan  : " . $bulane['ket'] . " " . $tahun . "\n" .
         "Nama   : " . $nama . "\n" .
         "Tgl Trx: " . date('d-m-Y', strtotime($tgl)) . "\n" .
         "Besar  : RP. " . number_format($besar) . "\n" .
         "Saldo  : RP. " . number_format($saldomu) . "\n" .
         "Reff   : " . $data['bukti'] . "\n";

sendWA($nowa, $notif, $url_api, $token);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

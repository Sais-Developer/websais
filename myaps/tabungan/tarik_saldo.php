<?php
require("../../konek/koneksi.php");
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
$idsiswa = $_POST['idsiswa'];
$tanggal = date('Y-m-d');
$jam = date('H:i:s');
$besar = $_POST['besar'];
$saldo = $_POST['saldo'];
$duit = filter_var($besar, FILTER_SANITIZE_NUMBER_INT);

if ($duit > $saldo) {
    exit;
}

$pdo->beginTransaction();

try {
    $stmt = $pdo->prepare("INSERT INTO saldo (tanggal, jam, idsiswa, kredit) VALUES (?, ?, ?, ?)");
    $stmt->execute([$tanggal, $jam, $idsiswa, $duit]);
    $stmt = $pdo->prepare("UPDATE siswa SET saldo = saldo - ? WHERE id_siswa = ?");
    $stmt->execute([$duit, $idsiswa]);

    $pdo->commit();

    $stmtSis = $pdo->prepare("SELECT nowa, nama, saldo FROM siswa WHERE id_siswa = ? LIMIT 1");
    $stmtSis->execute([$idsiswa]);
    $siswa = $stmtSis->fetch(PDO::FETCH_ASSOC);

    $nowa = $siswa['nowa'];
    $notif = "Assalamualaikum wr.wb\n\nKami informasikan kepada Orang Tua ananda *" . $siswa['nama'] . "*\nBahwa hari ini tanggal *" . date('d M Y') . "* telah menarik Saldo Tabungan sebesar Rp *" . number_format($duit, 0, ',', '.') . "* dengan *Sisa Total Saldo* saat ini sebesar *Rp " . number_format($siswa['saldo'], 0, ',', '.') . "*\n\nDemikian Informasi ini disampaikan secara Otomatis oleh *Server " . $setting['sekolah'] . "*\nHarap menjadi Monitoring Tabungan siswa, kepada Orang Tua Siswa. Tidak perlu dibalas. Terima kasih\n\nWasalamualaikum wr.wb";
    sendWA($nowa, $notif, $url_api, $token);
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Terjadi kesalahan: " . $e->getMessage();
}

$pdo = null; 
?>

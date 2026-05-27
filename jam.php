<?php
require(__DIR__ . "/konek/koneksi.php");

$hari        = date('D');
$waktusandik = date('H:i');
$waktu       = date('H:i:s');

$stmt = $pdo->prepare("SELECT * FROM pengaturan WHERE id_aplikasi = 1 LIMIT 1");
$stmt->execute();
$setting = $stmt->fetch() ?: [];

$stmt = $pdo->prepare("SELECT mode FROM status LIMIT 1");
$stmt->execute();
$mode_absen = (int)($stmt->fetchColumn() ?: 0);

$stmt = $pdo->prepare("
    UPDATE bell
    SET sudah_main = 0
    WHERE sudah_main = 1
      AND waktu_main IS NOT NULL
      AND TIMESTAMPDIFF(MINUTE, waktu_main, NOW()) >= 10
");
$stmt->execute();

$stmt = $pdo->prepare("
    SELECT * FROM bell
    WHERE jam = ?
      AND hari = ?
      AND sudah_main = 0
    LIMIT 1
");
$stmt->execute([$waktusandik, $hari]);
$row = $stmt->fetch() ?: [];

if (!empty($row)) {
    $now = date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("
        UPDATE bell 
        SET sudah_main = 1, waktu_main = ?
        WHERE id = ?
    ");
    $stmt->execute([$now, $row['id']]);
}

$nada = $row['nada'] ?? '';

switch ($mode_absen) {
    case 2: $status = ">>> Pulang"; break;
    case 3: $status = " Masuk Les"; break;
    case 4: $status = "Pulang Les"; break;
    case 5: $status = " Pkt Malam"; break;
    default: $status = ">>>> Masuk"; break;
}

echo $waktusandik . " " . $status;

if (in_array($setting['mesin'] ?? 0, [2, 5])) {
    echo $nada;
}

$stmt = $pdo->prepare("SELECT * FROM waktu WHERE hari = ?");
$stmt->execute([$hari]);

while ($data = $stmt->fetch()) {
    $masuk        = $data['masuk'] ?? '';
    $pulang       = $data['pulang'] ?? '';
    $masuk_eskul  = $data['masuk_eskul'] ?? '';
    $pulang_eskul = $data['pulang_eskul'] ?? '';
    $piket        = $data['piket'] ?? '';

    if (!empty($masuk) && strtotime($waktusandik) <= strtotime($pulang)) {
        $pdo->query("UPDATE status SET mode='1'");
        break;
    }
    
    if (!empty($pulang) && strtotime($waktusandik) >= strtotime($pulang)) {
        $pdo->query("UPDATE status SET mode='2'");
        break;
    }
    
    if (!empty($masuk_eskul) && strtotime($waktusandik) >= strtotime($masuk_eskul) 
        && strtotime($waktusandik) < strtotime($pulang_eskul)) {
        $pdo->query("UPDATE status SET mode='3'");
        break;
    }
   
    if (!empty($pulang_eskul) && strtotime($waktusandik) >= strtotime($pulang_eskul)) {
        $pdo->query("UPDATE status SET mode='4'");
        break;
    }
    
    if (!empty($piket) && strtotime($waktusandik) >= strtotime($piket)) {
        $pdo->query("UPDATE status SET mode='5'");
        break;
    }
}
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
if (!empty($setting) && ($setting['notif'] ?? '') == $waktu) {
    $stmt = $pdo->prepare("SELECT * FROM jadwal_mengajar WHERE hari = ?");
    $stmt->execute([$hari]);
    while ($datax = $stmt->fetch()) {

        $guru_id  = (int)$datax['guru'];
        $mapel_id = (int)$datax['mapel'];
        $kelas    = $datax['kelas'] ?? '-';

        $stmt2 = $pdo->prepare("SELECT nowa FROM guru WHERE id_guru = ?");
        $stmt2->execute([$guru_id]);
        $nowa = $stmt2->fetchColumn() ?: '';

        $stmt3 = $pdo->prepare("SELECT nama_mapel FROM mapel WHERE id = ?");
        $stmt3->execute([$mapel_id]);
        $nama_mapel = $stmt3->fetchColumn() ?: '-';

        if (!empty($nowa)) {

            $notifmu =
                "Assalamualaikum wr.wb\n\n".
                "Kami informasikan bahwa hari ini Bapak/Ibu Guru ada jadwal KBM di ".($setting['sekolah'] ?? '-')."\n\n".
                "Mata Pelajaran *$nama_mapel* Kelas *$kelas*\n\n".
                "Dari jam ".$datax['dari']." sampai ".$datax['sampai']."\n\n".
                "Pesan ini dikirim otomatis dari sistem. Terima kasih.\n\n".
                "Wassalamualaikum wr.wb";

            sendWA($nowa, $notifmu, $url_api, $token);

            sleep(1);
        }
    }
}

?>

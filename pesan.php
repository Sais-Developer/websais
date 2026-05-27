<?php
require(__DIR__ . "/konek/koneksi.php");

$tanggal  = date('Y-m-d');
$tglabsen = date('d M Y H:i:s');

$nokartu = htmlspecialchars($_GET['nokartu'] ?? '');
if (!$nokartu) {
    exit('No card data');
}

$stmt = $pdo->query("SELECT * FROM status LIMIT 1");
$status = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];

$stmt = $pdo->prepare("SELECT * FROM datareg WHERE nokartu = ? LIMIT 1");
$stmt->execute([$nokartu]);
$data = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];


$pesan = [];
$stmt = $pdo->prepare("SELECT * FROM m_pesan WHERE id = ?");
for ($i = 1; $i <= 8; $i++) {
    $stmt->execute([$i]);
    $pesan[$i] = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
}

$notif = [
    'masuk_siswa'   => "{$pesan[1]['pesan1']}\n\n{$pesan[1]['pesan2']}\n*{$data['nama']}*\n\n{$pesan[1]['pesan3']} $tglabsen\n\n{$pesan[1]['pesan4']}",
    'pulang_siswa'  => "{$pesan[2]['pesan1']}\n\n{$pesan[2]['pesan2']}\n*{$data['nama']}*\n\n{$pesan[2]['pesan3']} $tglabsen\n\n{$pesan[2]['pesan4']}",
    'masuk_peg'     => "{$pesan[3]['pesan1']}\n\n{$pesan[3]['pesan2']}\n*{$data['nama']}*\n\n{$pesan[3]['pesan3']} $tglabsen\n\n{$pesan[3]['pesan4']}",
    'pulang_peg'    => "{$pesan[4]['pesan1']}\n\n{$pesan[4]['pesan2']}\n*{$data['nama']}*\n\n{$pesan[4]['pesan3']} $tglabsen\n\n{$pesan[4]['pesan4']}",
    'masuk_eksiswa' => "{$pesan[5]['pesan1']}\n\n{$pesan[5]['pesan2']}\n*{$data['nama']}*\n\n{$pesan[5]['pesan3']} $tglabsen\n\n{$pesan[5]['pesan4']}",
    'pulang_eksiswa'=> "{$pesan[6]['pesan1']}\n\n{$pesan[6]['pesan2']}\n*{$data['nama']}*\n\n{$pesan[6]['pesan3']} $tglabsen\n\n{$pesan[6]['pesan4']}",
    'masuk_ekpeg'   => "{$pesan[7]['pesan1']}\n\n{$pesan[7]['pesan2']}\n*{$data['nama']}*\n\n{$pesan[7]['pesan3']} $tglabsen\n\n{$pesan[7]['pesan4']}",
    'pulang_ekpeg'  => "{$pesan[8]['pesan1']}\n\n{$pesan[8]['pesan2']}\n*{$data['nama']}*\n\n{$pesan[8]['pesan3']} $tglabsen\n\n{$pesan[8]['pesan4']}"
];
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

$stmt = $pdo->prepare("SELECT COUNT(*) AS jml FROM datareg WHERE nokartu = ?");
$stmt->execute([$nokartu]);
$row = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
$cek = (int)($row['jml'] ?? 0);

if ($cek > 0) {
    $level = $data['level'] ?? '';
    $mode  = $status['mode'] ?? '';

    switch ($mode) {
        case '1': 
            if ($level == 'pegawai') {
				sendWA($setting['nowa'], $notif['masuk_peg'], $url_api, $token);
                sleep(1);
				sendWA($data['nowa'], $notif['masuk_peg'], $url_api, $token);
            } elseif ($level == 'siswa') {
				sendWA($data['nowa'], $notif['masuk_siswa'], $url_api, $token);
            }
            break;

        case '2': 
            if ($level == 'pegawai') {
				sendWA($setting['nowa'], $notif['pulang_peg'], $url_api, $token);
                sleep(1);
               sendWA($data['nowa'], $notif['pulang_peg'], $url_api, $token);
            } elseif ($level == 'siswa') {
				sendWA($data['nowa'], $notif['pulang_siswa'], $url_api, $token);
            }
            break;

        case '3': 
            if ($level == 'pegawai') {
				sendWA($setting['nowa'], $notif['masuk_ekpeg'], $url_api, $token);
                sleep(1);
                sendWA($data['nowa'], $notif['masuk_ekpeg'], $url_api, $token);
            } elseif ($level == 'siswa') {
				sendWA($data['nowa'], $notif['masuk_eksiswa'], $url_api, $token);
            }
            break;

        case '4': 
            if ($level == 'pegawai') {
               sendWA($setting['nowa'], $notif['pulang_ekpeg'], $url_api, $token);
                sleep(1);
               sendWA($data['nowa'], $notif['pulang_ekpeg'], $url_api, $token);
            } elseif ($level == 'siswa') {
               sendWA($setting['nowa'], $notif['pulang_eksiswa'], $url_api, $token);
            }
            break;
    }
}
?>

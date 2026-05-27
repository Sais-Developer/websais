<?php
require("konek/koneksi.php");   
require("konek/function.php");
require("konek/crud.php");

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



$hari = date('D');
$stmt = $pdo->prepare("SELECT * FROM waktu WHERE hari = ?");
$stmt->execute([$hari]);
$harix = $stmt->fetch(PDO::FETCH_ASSOC);

$tglabsen = date('d M Y H:i:s');
$jamu = date('H:i');
$tanggal = date('Y-m-d');
$jamabsen = date('H:i:s');
$bulan = date('m');
$tahun = date('Y');

$jam_masuk  = strtotime($harix['masuk']);
$jam_eskul  = strtotime($harix['jam_eskul']);
$jam_datang = strtotime($jamu);												

$selisih = $jam_datang - $jam_masuk;
if($selisih > 0){
    $jam   = floor($selisih / (60 * 60));
    $menit = $selisih - ($jam * 60 * 60);
    $ket = 'Terlambat '.$jam.' jam, '.floor($menit / 60).' menit';
} else {
    $ket = "Tepat Waktu";	
}


if (isset($_POST['Get_Fingerid'])) {
    $stmt = $pdo->query("SELECT * FROM datareg ORDER BY idjari DESC LIMIT 1");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $output = [
        "Detail" => [
            "Data User" => $data['nama'],
            "Data ID" => $data['idjari'],
            "Data Serial" => $data['serialnumber']
        ]
    ];
    echo json_encode($output);

    $stmt = $pdo->prepare("UPDATE datareg SET sts='1' WHERE idjari=?");
    $stmt->execute([$data['idjari']]);
}

if (isset($_POST['Hapus_id'])) {
    $stmt = $pdo->query("SELECT * FROM temp_finger ORDER BY id DESC LIMIT 1");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $output = [
        "Detail" => [
            "Data User" => $data['nama'],
            "Data ID" => $data['idjari'],
            "Data Serial" => $data['serial']
        ]
    ];
    echo json_encode($output);

    delete('temp_finger', ['idjari' => $data['idjari']]);
}

if (isset($_POST['uid'])) {
    $idj = $_POST['uid'];

    $stmt = $pdo->query("SELECT * FROM status");
    $status = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM datareg WHERE idjari=?");
    $stmt->execute([$idj]);
    $cek = $stmt->rowCount();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cek == 0) {
        echo "TIDAK TERDAFTAR";  
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM absensi WHERE nokartu=? AND tanggal=?");
    $stmt->execute([$idj, $tanggal]);
    $jumlah_absen = $stmt->rowCount();
    $nowa = $data['nowa'];
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
 
    if ($status['mode'] == '1') { 
		 if ($jumlah_absen > 0) {
				echo "GAGAL"; 
				exit;
			}	
        if ($data['level'] == 'pegawai') {       
            $stmt = $pdo->prepare("INSERT INTO absensi(nokartu,tanggal,idpeg,masuk,ket,bulan,tahun,level,keterangan) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$idj, $tanggal, $data['idpeg'], $jamabsen, 'H', $bulan, $tahun, 'pegawai', $ket]);
            sendWA($nowa, $notif['masuk_peg'], $url_api, $token);
		
		} else {
            
            $stmt = $pdo->prepare("INSERT INTO absensi(nokartu,tanggal,idsiswa,kelas,masuk,ket,bulan,tahun,level,keterangan) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$idj, $tanggal, $data['idsiswa'], $data['kelas'], $jamabsen, 'H', $bulan, $tahun, 'siswa', $ket]);
		   sendWA($nowa, $notif['masuk_siswa'], $url_api, $token);

		}

        echo $data['nama'];
    }
    if ($status['mode'] == '2') { 
    $stmt = $pdo->prepare("UPDATE absensi SET pulang = :pulang WHERE nokartu = :nokartu AND tanggal = :tanggal");
    $stmt->execute([
        ':pulang' => $jamabsen, 
        ':nokartu' => $idj, 
        ':tanggal' => $tanggal 
    ]);
    echo $data['nama'];
	}

}
?>

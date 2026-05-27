<?php
require("konek/koneksi.php");  

$hari = date('D');
$waktusandik = date('H:i');
$waktu = date('H:i:s');
$bul = date('m');
$th = date('Y');
$tanggal = date('Y-m-d');

$stmt = $pdo->query("SELECT * FROM status");
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$mode_absen = $data['mode'];

if ($mode_absen == 1) {
    echo $waktusandik . " >>>> Masuk";
} else if ($mode_absen == 2) {
    echo $waktusandik . " >>> Pulang";
} else if ($mode_absen == 3) {
    echo $waktusandik . " Masuk Les ";
} else if ($mode_absen == 4) {
    echo $waktusandik . " Pulang Les ";
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

$stmt = $pdo->prepare("SELECT * FROM waktu WHERE hari = :hari");
$stmt->execute(['hari' => $hari]);

while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) :
    if ($waktu == strtotime($data['alpha'])) :
        $stmt2 = $pdo->prepare("
            SELECT id_siswa, kelas, nowa 
            FROM siswa 
            WHERE NOT EXISTS (
                SELECT idsiswa, tanggal, kelas 
                FROM absensi 
                WHERE siswa.id_siswa = absensi.idsiswa 
                AND absensi.tanggal = :tgl
            )
        ");
        $stmt2->execute(['tgl' => $tanggal]);
        while ($sis = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $cekStmt = $pdo->prepare("
                SELECT idsiswa 
                FROM absensi 
                WHERE idsiswa = :id 
                AND tanggal = :tgl
            ");
            $cekStmt->execute([
                'id' => $sis['id_siswa'],
                'tgl' => $tanggal
            ]);

            if ($cekStmt->rowCount() == 0) {
                $insert = $pdo->prepare("
                    INSERT INTO absensi
                    (tanggal, idsiswa, kelas, ket, masuk, pulang, level, bulan, tahun)
                    VALUES
                    (:tgl, :id, :kelas, 'A', :msk, :plg, 'siswa', :bulan, :tahun)
                ");
                $insert->execute([
                    'tgl'   => $tanggal,
                    'id'    => $sis['id_siswa'],
                    'kelas' => $sis['kelas'],
                    'msk'   => $waktu,
                    'plg'   => $waktu,
                    'bulan' => $bul,
                    'tahun' => $th
                ]);
				$notif = "Assalamualaikum wr.wb\n\nKami informasikan bahwa ananda :\n*".$sis['nama']."*\nPada hari ini tidak mengikuti *Kegiatan Belajar Mengajar* di ".$setting['sekolah']." tanpa ada keterangan apapun dari Orang Tua Siswa (Alpha).Demikian informasi ini disampaikan sebagai
				sarana monitoring terhadap putra putri bapak/ibu selaku orfang tua siswa.\n\nInformasi ini dikirim otomatis via *Server Sekolah* dan tidak perlu dibalas\n\nWassalamualaikum.wr.wb";
				sendWA($sis['nowa'], $notif, $url_api, $token);
				 sleep(1);
            }
        }
    endif;

endwhile;

?>

<?php
require("../../konek/koneksi.php");

$idpel   = $_POST['idpel'];
$idsiswa = $_POST['idsiswa'];

$stmt = $pdo->prepare("SELECT poin, nama_pelanggaran FROM pelanggaran WHERE id = :idpel LIMIT 1");
$stmt->execute(['idpel' => $idpel]);
$jenis = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null;

$poin = $jenis['poin'] ?? 0;
$tanggal = date('Y-m-d');

$stmt2 = $pdo->prepare("
    INSERT INTO catatan_pelanggaran (idpel, id_siswa, poin, tanggal)
    VALUES (:idpel, :idsiswa, :poin, :tanggal)
");
$stmt2->execute([
    'idpel' => $idpel,
    'idsiswa' => $idsiswa,
    'poin' => $poin,
    'tanggal' => $tanggal
]);
$stmt2 = null;

$update = $pdo->prepare("
    UPDATE siswa SET total_poin = total_poin + :poin WHERE id_siswa = :idsiswa
");
$update->execute(['poin' => $poin, 'idsiswa' => $idsiswa]);
$update = null;

$cek = $pdo->prepare("SELECT total_poin FROM siswa WHERE id_siswa = :idsiswa LIMIT 1");
$cek->execute(['idsiswa' => $idsiswa]);
$data = $cek->fetch(PDO::FETCH_ASSOC);
$cek = null;

$total_poin = $data['total_poin'] ?? 0;

$stmt3 = $pdo->prepare("
    SELECT id_teguran 
    FROM teguran 
    WHERE :total_poin BETWEEN min_poin AND max_poin
    LIMIT 1
");
$stmt3->execute(['total_poin' => $total_poin]);
$teguran = $stmt3->fetch(PDO::FETCH_ASSOC);
$stmt3 = null;

if (!empty($teguran)) {
    $id_teguran = $teguran['id_teguran'];
    $update2 = $pdo->prepare("
        UPDATE siswa 
        SET id_teguran = :id_teguran
        WHERE id_siswa = :idsiswa
    ");
    $update2->execute(['id_teguran' => $id_teguran, 'idsiswa' => $idsiswa]);
    $update2 = null;
}

$stmtSis = $pdo->prepare("SELECT nowa, nama, total_poin FROM siswa WHERE id_siswa = :idsiswa LIMIT 1");
$stmtSis->execute(['idsiswa' => $idsiswa]);
$siswa = $stmtSis->fetch(PDO::FETCH_ASSOC);
$stmtSis = null;

$nowa = $siswa['nowa'] ?? '';
if(substr($nowa,0,1) === '0'){
    $nowa = '62'.substr($nowa,1);
}
$notif = "Assalamualaikum wr.wb\n\nKami informasikan kepada Orang Tua ananda *".$siswa['nama']. "*\nBahwa hari ini tanggal *".date('d M Y')."* telah melakukan pelanggaran Tata tertib sekolah berupa *".$jenis['nama_pelanggaran']."* dengan *Total Point* pelanggaran sudah mencapai sebesar ".$siswa['total_poin']." poin\n\nDemikian Informasi ini disampaikan secara Otomatis oleh *Server ".$setting['sekolah']."*\nHarap menjadi perhatian kepada Orang Tua Siswa. Tidak perlu dibalas. Terima kasih\n\nWasalamualaikum wr.wb";

function kirimWA($nomor, $pesan)
{
    global $setting;
    if (empty($nomor) || empty($pesan)) return false;

    $url = rtrim($setting['url_api'] ?? '', '/');
    if (!$url) return false;

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url . '/send-message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'number'  => $nomor,
            'message' => $pesan
        ]),
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => false
    ]);

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        error_log('CURL Error: ' . curl_error($curl));
    }
    curl_close($curl);
    return $response;
}

kirimWA($nowa, $notif);
?>

<?php
require("../konek/koneksi.php");
header('Content-Type: application/json');

$hari     = date('D');
$waktu    = date('H:i');
$tanggal  = date('Y-m-d');
$jamabsen = date('H:i:s');
$bulan    = date('m');
$tahun    = date('Y');

$pdo->exec("TRUNCATE tmpreg");

$nokartu = $_GET['nokartu'] ?? '';

if (!$nokartu) {
    echo "KOSONG";
    exit;
}

/* =============================
   CEK REGISTRASI
   ============================= */
$stmt = $pdo->prepare("
    SELECT d.*, g.level AS level_pegawai
    FROM datareg d
    LEFT JOIN guru g ON g.id_guru = d.idpeg
    WHERE d.nokartu = :nokartu
");
$stmt->execute(['nokartu' => $nokartu]);
$reg = $stmt->fetch(PDO::FETCH_ASSOC);

$nama    = $reg['nama'] ?? '';
$kelas   = $reg['kelas'] ?? '';
$idpeg   = $reg['idpeg'] ?? '';
$idsiswa = $reg['idsiswa'] ?? '';
$level   = $reg['level'] ?? '';
$levpeg  = $reg['level_pegawai'] ?? '';
$hadir   = 'H';

$mesin = $setting['mesin'] ?? 0;

if (!$reg) {
    if ($mesin == 2) {
        echo json_encode(["status" => "error", "message" => "TIDAK TERDAFTAR"]);
    } else {
        echo "TIDAK TERDAFTAR";
    }

    $stmt = $pdo->prepare("INSERT INTO tmpreg(nokartu) VALUES(:nokartu)");
    $stmt->execute(['nokartu' => $nokartu]);
    exit;
}

echo ($mesin == 2)
    ? json_encode(["status"=>"success","nada"=>$reg['nada'] ?? '','nama'=>$nama])
    : $nama;

/* =============================
   STATUS & WAKTU
   ============================= */
$status = $pdo->query("SELECT * FROM status LIMIT 1")->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM waktu WHERE hari=:hari");
$stmt->execute(['hari'=>$hari]);
$harix = $stmt->fetch(PDO::FETCH_ASSOC);

$jam_masuk  = strtotime($harix['masuk'] ?? '00:00:00');
$jam_eskul  = strtotime($harix['masuk_eskul'] ?? '00:00:00');
$jam_datang = strtotime($waktu);

$selisih = 0;
if ($status['mode'] == '1') $selisih = $jam_datang - $jam_masuk;
elseif ($status['mode'] == '3') $selisih = $jam_datang - $jam_eskul;

$ket = ($selisih > 0)
    ? "Terlambat ".floor($selisih/3600)." jam, ".floor(($selisih%3600)/60)." menit"
    : "Tepat Waktu";

/* =============================
   ABSENSI MASUK
   ============================= */
$stmt = $pdo->prepare("SELECT COUNT(*) FROM absensi WHERE nokartu=:nokartu AND tanggal=:tanggal");
$stmt->execute(['nokartu'=>$nokartu,'tanggal'=>$tanggal]);
$jumlah_absen = $stmt->fetchColumn();

if ($status['mode']=='1' && $jumlah_absen==0) {
    if ($level=='pegawai') {
        $stmt = $pdo->prepare("
            INSERT INTO absensi
            (nokartu,tanggal,idpeg,masuk,ket,bulan,tahun,level,keterangan)
            VALUES (:nokartu,:tanggal,:idpeg,:masuk,:ket,:bulan,:tahun,:level,:keterangan)
        ");
        $stmt->execute([
            'nokartu'=>$nokartu,'tanggal'=>$tanggal,'idpeg'=>$idpeg,
            'masuk'=>$jamabsen,'ket'=>$hadir,'bulan'=>$bulan,
            'tahun'=>$tahun,'level'=>$level,'keterangan'=>$ket
        ]);
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO absensi
            (nokartu,tanggal,idsiswa,kelas,level,masuk,ket,bulan,tahun,keterangan)
            VALUES (:nokartu,:tanggal,:idsiswa,:kelas,:level,:masuk,:ket,:bulan,:tahun,:keterangan)
        ");
        $stmt->execute([
            'nokartu'=>$nokartu,'tanggal'=>$tanggal,'idsiswa'=>$idsiswa,
            'kelas'=>$kelas,'level'=>$level,'masuk'=>$jamabsen,
            'ket'=>$hadir,'bulan'=>$bulan,'tahun'=>$tahun,'keterangan'=>$ket
        ]);
    }
}

/* =============================
   PULANG
   ============================= */
if ($status['mode']=='2') {
    $stmt = $pdo->prepare("
        UPDATE absensi SET pulang=:pulang
        WHERE nokartu=:nokartu AND tanggal=:tanggal
    ");
    $stmt->execute([
        'pulang'=>$jamabsen,
        'nokartu'=>$nokartu,
        'tanggal'=>$tanggal
    ]);
}

/* =============================
   ABSENSI LES
   ============================= */
$stmt = $pdo->prepare("SELECT COUNT(*) FROM absensi_les WHERE nokartu=:nokartu AND tanggal=:tanggal");
$stmt->execute(['nokartu'=>$nokartu,'tanggal'=>$tanggal]);
$jumlah_eskul = $stmt->fetchColumn();

if ($status['mode']=='3' && $jumlah_eskul==0) {
    $stmt = ($level=='pegawai')
        ? $pdo->prepare("
            INSERT INTO absensi_les
            (nokartu,tanggal,idpeg,masuk,ket,bulan,tahun,level,keterangan)
            VALUES (:nokartu,:tanggal,:idpeg,:masuk,:ket,:bulan,:tahun,:level,:keterangan)
          ")
        : $pdo->prepare("
            INSERT INTO absensi_les
            (nokartu,tanggal,idsiswa,kelas,masuk,ket,bulan,tahun,level,keterangan)
            VALUES (:nokartu,:tanggal,:idsiswa,:kelas,:masuk,:ket,:bulan,:tahun,:level,:keterangan)
          ");

    $stmt->execute([
        'nokartu'=>$nokartu,'tanggal'=>$tanggal,'idpeg'=>$idpeg ?? null,
        'idsiswa'=>$idsiswa ?? null,'kelas'=>$kelas ?? null,
        'masuk'=>$jamabsen,'ket'=>$hadir,'bulan'=>$bulan,
        'tahun'=>$tahun,'level'=>$level,'keterangan'=>$ket
    ]);
}

if ($status['mode']=='4') {
    $stmt = $pdo->prepare("
        UPDATE absensi_les SET pulang=:pulang
        WHERE nokartu=:nokartu AND tanggal=:tanggal
    ");
    $stmt->execute([
        'pulang'=>$jamabsen,
        'nokartu'=>$nokartu,
        'tanggal'=>$tanggal
    ]);
}
?>

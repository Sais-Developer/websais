<?php
require("konek/koneksi.php");
header('Content-Type: text/plain');  

$hari     = date('D');
$waktu    = date('H:i');
$tanggal  = date('Y-m-d');
$jamabsen = date('H:i:s');
$bulan    = date('m');
$tahun    = date('Y');
$waktumu  = date('H:i:s');

$nokartu = $_POST['nokartu'] ?? '';
$idface = $_POST['idface'] ?? '';

if (!$nokartu && !$idface) {
    exit;
}

$stmtReg = $pdo->prepare("
    SELECT d.*, g.level AS level_pegawai
    FROM datareg d
    LEFT JOIN guru g ON g.id_guru = d.idpeg
    WHERE d.nokartu = ? AND d.folder = ?
");
$stmtReg->execute([$nokartu, $idface]);
$reg = $stmtReg->fetch(PDO::FETCH_ASSOC);

if (!$reg) {
    exit;
}

$nama    = $reg['nama'] ?? '';
$kelas   = $reg['kelas'] ?? '';
$idpeg   = $reg['idpeg'] ?? '';
$idsiswa = $reg['idsiswa'] ?? '';
$level   = $reg['level'] ?? '';            
$levpeg  = $reg['level_pegawai'] ?? '';    
$hadir   = 'H';

$stmt = $pdo->query("SELECT * FROM status LIMIT 1");
$status = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM waktu WHERE hari=?");
$stmt->execute([$hari]);
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


$stmt = $pdo->prepare("SELECT COUNT(*) AS jumlah FROM absensi WHERE nokartu=? AND tanggal=?");
$stmt->execute([$nokartu, $tanggal]);
$jumlah_absen = $stmt->fetch(PDO::FETCH_ASSOC)['jumlah'] ?? 0;

if ($status['mode'] == '1' && $jumlah_absen == 0) {    
    if ($level == 'pegawai') {
        $sql = "INSERT INTO absensi(nokartu,tanggal,idpeg,masuk,ket,bulan,tahun,level,keterangan)
                VALUES(?,?,?,?,?,?,?,?,?)";
        $pdo->prepare($sql)->execute([$nokartu, $tanggal, $idpeg, $jamabsen, $hadir, $bulan, $tahun, $level, $ket]);
		echo "OK";
    } else {
        $sql = "INSERT INTO absensi(nokartu,tanggal,idsiswa,kelas,level,masuk,ket,bulan,tahun,keterangan)
                VALUES(?,?,?,?,?,?,?,?,?,?)";
        $pdo->prepare($sql)->execute([$nokartu, $tanggal, $idsiswa, $kelas, $level, $jamabsen, $hadir, $bulan, $tahun, $ket]);
      echo "OK";
   }
}

if ($status['mode'] == '1' && $levpeg == 'guru') {
    $sql = "SELECT j.*, g.level AS level_guru
            FROM jadwal_mengajar j
            LEFT JOIN guru g ON g.id_guru = j.guru
            WHERE j.hari = ? AND j.guru = ? 
              AND STR_TO_DATE(j.sampai, '%H:%i') >= STR_TO_DATE(?, '%H:%i')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$hari, $idpeg, $waktu]);
    $dataqu = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dataqu) {
        $sampai = $dataqu['sampai'];  
        $dari   = $dataqu['dari'];    

        if (strtotime($waktu) <= strtotime($dari)) {
            $jjm = $dataqu['jjm']; 
            $status_absen = "tepat waktu"; 
        } else {
            $status_absen = "terlambat";
            $selisihq = strtotime($sampai) - strtotime($waktu);
            if ($selisihq < 0) $selisihq = 0; 
            $jamq   = floor($selisihq / 3600);
            $menitq = $selisihq - ($jamq * 3600);
            $jjm = (($jamq * 60) + floor($menitq / 60)) / $setting['jjm']; 
        }

        $jadwal = $dataqu['id_jadwal'];

        $sql_check = "SELECT COUNT(*) AS jumlah FROM absen_jjm WHERE idpeg = ? AND jadwal = ? AND tanggal = ?";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->execute([$idpeg, $jadwal, $tanggal]);
        $cek = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (($cek['jumlah'] ?? 0) == 0) {
            $sql_insert = "INSERT INTO absen_jjm (tanggal, idpeg, masuk, ket, jjm, bulan, tahun, jadwal) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $pdo->prepare($sql_insert)->execute([$tanggal, $idpeg, $jamabsen, $status_absen, $jjm, $bulan, $tahun, $jadwal]);
        echo "OK";
		}
    }
}

if ($status['mode'] == '2') {
    $pdo->prepare("UPDATE absensi SET pulang=? WHERE nokartu=? AND tanggal=?")
        ->execute([$jamabsen, $nokartu, $tanggal]);
		echo "OK";
}

if ($status['mode'] == '3') {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS jumlah FROM absensi_les WHERE nokartu=? AND tanggal=?");
    $stmt->execute([$nokartu, $tanggal]);
    $jumlah_eskul = $stmt->fetch(PDO::FETCH_ASSOC)['jumlah'] ?? 0;

    if ($jumlah_eskul == 0) {
        if ($level == 'pegawai') {
            $sql = "INSERT INTO absensi_les(nokartu,tanggal,idpeg,masuk,ket,bulan,tahun,level,keterangan)
                    VALUES(?,?,?,?,?,?,?,?,?)";
            $pdo->prepare($sql)->execute([$nokartu, $tanggal, $idpeg, $jamabsen, $hadir, $bulan, $tahun, $level, $ket]);
        echo "OK";
	   } else {
            $sql = "INSERT INTO absensi_les(nokartu,tanggal,idsiswa,kelas,masuk,ket,bulan,tahun,level,keterangan)
                    VALUES(?,?,?,?,?,?,?,?,?,?)";
            $pdo->prepare($sql)->execute([$nokartu, $tanggal, $idsiswa, $kelas, $jamabsen, $hadir, $bulan, $tahun, $level, $ket]);
        echo "OK";
		}
    }
}

if ($status['mode'] == '4') {
    $pdo->prepare("UPDATE absensi_les SET pulang=? WHERE nokartu=? AND tanggal=?")
        ->execute([$jamabsen, $nokartu, $tanggal]);
		echo "OK";
}
$pdo->exec("TRUNCATE TABLE tmpface");
?>

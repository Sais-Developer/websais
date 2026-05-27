<?php
require(__DIR__ . "/konek/koneksi.php"); 

$stmt = $pdo->prepare("SELECT mode FROM status LIMIT 1");
$stmt->execute();
$mode_absen = (int)($stmt->fetchColumn() ?: 0);

$tanggal = date('Y-m-d');
$waktusandik = date('H:i:s');

$pg = $_GET['pg'] ?? '';

if ($pg === 'jam') {
	switch ($mode_absen) {
    case 2: $status = "Pulang"; break;
    case 3: $status = "Masuk Les"; break;
    case 4: $status = "Pulang Les"; break;
    case 5: $status = "Piket Malam"; break;
    default: $status = "Masuk"; break;
}
echo $waktusandik . " " . $status;
}
if ($pg === 'absensi') {
    if ($mode_absen == 1) { 
        $sql = "SELECT a.*, d.nama
                FROM absensi a 
                LEFT JOIN datareg d ON d.nokartu = a.nokartu
                WHERE a.tanggal = :tanggal AND a.masuk IS NOT NULL
                ORDER BY a.id DESC 
                LIMIT 3";  
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $absenData = "";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Menentukan keterangan absen
                if($row['ket']=='H') { $ket = 'Hadir'; }
                if($row['ket']=='S') { $ket = 'Sakit'; }
                if($row['ket']=='I') { $ket = 'Izin'; }
                if($row['ket']=='A') { $ket = 'Alpha'; }

         
                $absenData .= $row['nama'] ." ". $ket. " " . $row['masuk']. " ". $row['keterangan'] . " ";
            }
        } else {
            $absenData = "Tidak ada Aktifitas Presensi Masuk Sekolah";
        }
        echo $absenData;

    } elseif ($mode_absen == 2) {  
        $sql = "SELECT a.nokartu, a.tanggal, a.pulang, d.nama
                FROM absensi a 
                LEFT JOIN datareg d ON d.nokartu = a.nokartu
                WHERE a.tanggal = :tanggal AND a.pulang IS NOT NULL
                ORDER BY a.id DESC 
                LIMIT 3";  
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':tanggal', $tanggal, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $absenData = "";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                
                $absenData .= $row['nama'] . " Pulang: " . $row['pulang']. " ";
            }
        } else {
            $absenData = "Tidak ada Aktifitas Presensi Pulang Sekolah";
        }
        echo $absenData;
    } else {
        echo "";
    }
}

if ($pg === 'jadwal') {
    $hari = date('D');
    $jam = date('H:i');

    $stmt = $pdo->prepare("SELECT j.kelas, j.dari, j.sampai, g.nama, g.foto, m.nama_mapel
        FROM jadwal_mengajar j
        LEFT JOIN guru g ON g.id_guru = j.guru
        LEFT JOIN mapel m ON m.id = j.mapel
        WHERE j.hari = :hari AND j.dari < :jam_sampai AND j.sampai > :jam_dari AND g.level = 'guru'");
    $stmt->execute([
        ':hari' => $hari,
        ':jam_dari' => $jam,
        ':jam_sampai' => $jam
    ]);

    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            echo "Kelas: " . $data['kelas'] . " | Mata Pelajaran: " . $data['nama_mapel'] . 
                 " | Guru: " . $data['nama'] . " | Waktu: " . $data['dari'] . " - " . $data['sampai'] . " ";
        }
    } else {
        echo "Tidak ada Jadwal Aktif Saat ini";
    }
}

if ($pg === 'info') {
    $sql = "SELECT * FROM pengumuman ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $absenData = $row['isi'];  
		echo $absenData;
    } else {
        echo "Belum ada Informasi";  
    }
   
}

$pdo = null;
?>



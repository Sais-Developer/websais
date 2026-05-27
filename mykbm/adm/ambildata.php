<?php
require("../../konek/koneksi.php");
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';
if ($pg === 'kelas') {
    $guru = $_POST['guru'] ?? '';

    $stmt = $pdo->prepare("SELECT DISTINCT kelas FROM jadwal_mengajar WHERE guru = :guru");
    $stmt->bindParam(':guru', $guru, PDO::PARAM_STR);
    $stmt->execute();

    echo "<option value=''>Pilih Kelas</option>";

    while ($kls = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='".htmlspecialchars($kls['kelas'])."'>".
             htmlspecialchars($kls['kelas'])."</option>";
    }
}
if ($pg === 'mapel') {
    $guru  = $_POST['guru'] ?? '';
    $kelas = $_POST['kelas'] ?? '';

    $stmt = $pdo->prepare("
        SELECT jm.mapel, m.nama_mapel 
        FROM jadwal_mengajar jm
        LEFT JOIN mapel m ON m.id = jm.mapel
        WHERE guru = :guru AND kelas = :kelas
		GROUP BY jm.mapel
    ");
    $stmt->execute([
        ':guru'  => $guru,
        ':kelas' => $kelas
    ]);

    echo "<option value=''>Pilih Mapel</option>";

    while ($m = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='".htmlspecialchars($m['mapel'])."'>".
             htmlspecialchars($m['nama_mapel'])."</option>";
    }
}

if ($pg === 'level') {
    $guru = $_POST['guru'] ?? '';

    $stmt = $pdo->prepare("SELECT DISTINCT tingkat FROM jadwal_mengajar WHERE guru = :guru");
    $stmt->bindParam(':guru', $guru, PDO::PARAM_STR);
    $stmt->execute();

    echo "<option value=''>Pilih Tingkat</option>";

    while ($lv = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='".htmlspecialchars($lv['tingkat'])."'>".
             htmlspecialchars($lv['tingkat'])."</option>";
    }
}

if ($pg === 'elemen') {
    $guru  = $_POST['guru'] ?? '';
    $mapel = $_POST['mapel'] ?? '';
	$kelas = $_POST['kelas'] ?? '';
	
	$lev = fetch('m_kelas',['kelas'=>$kelas]);
    $tingkat = $lev['level'];
	
    $stmt = $pdo->prepare("
        SELECT c.id_elemen, c.ke 
        FROM adm_tp a 
        LEFT JOIN cp_elemen c ON c.id_lingkup = a.id 
        WHERE a.guru = :guru AND a.mapel = :mapel AND a.tingkat = :tingkat
    ");
    $stmt->execute([
        ':guru'  => $guru,
        ':mapel' => $mapel,
		 ':tingkat' => $tingkat
    ]);

    echo "<option value=''>Pilih Pertemuan ke</option>";

    while ($m = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='".htmlspecialchars($m['id_elemen'])."'>".
             htmlspecialchars($m['ke'])."</option>";
    }
}

if ($pg === 'materi') {
    $guru  = $_POST['guru'] ?? '';
    $mapel = $_POST['mapel'] ?? '';
    $kelas = $_POST['kelas'] ?? '';

    $stmt = $pdo->prepare("
        SELECT a.lingkup 
        FROM adm_tp a 
        JOIN m_kelas k ON k.level = a.tingkat 
        WHERE a.guru = :guru AND a.mapel = :mapel AND k.kelas = :kelas
    ");

    $stmt->execute([
        ':guru'  => $guru,
        ':mapel' => $mapel,
        ':kelas' => $kelas
    ]);

    echo "<option value=''>Pilih Materi</option>";

    while ($m = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $lingkup = htmlspecialchars($m['lingkup']);
        echo "<option value='{$lingkup}'>{$lingkup}</option>";
    }
}
if ($pg === 'tujuan') {
    $materi = $_POST['materi'] ?? '';

    $stmt = $pdo->prepare("SELECT tujuan FROM adm_tp WHERE lingkup = :lingkup");
    $stmt->bindParam(':lingkup', $materi, PDO::PARAM_STR);
    $stmt->execute();

    echo "<option value=''>Pilih TP</option>";

    while ($tp = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tujuan = htmlspecialchars($tp['tujuan']);
        echo "<option value='{$tujuan}'>{$tujuan}</option>";
    }
}
?>

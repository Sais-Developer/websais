<?php
require(__DIR__ . "/../../konek/koneksi.php");
$pg = $_GET['pg'] ?? '';

if ($pg === 'kelas') {
    $guru = $_POST['guru'] ?? '';
    if ($guru === '') {
        echo "<option value=''>Guru tidak valid</option>";
        exit;
    }

    $stmt = $pdo->prepare("SELECT DISTINCT kelas FROM jadwal_mengajar WHERE guru = ?");
    $stmt->execute([$guru]);
    $kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<option value=''>Pilih Kelas</option>";
    foreach ($kelasList as $k) {
        $kelas = htmlspecialchars($k['kelas']);
        echo "<option value='{$kelas}'>{$kelas}</option>";
    }
}

if ($pg === 'mapel') {
    $guru  = $_POST['guru'] ?? '';
    $kelas = $_POST['kelas'] ?? '';
    if ($guru === '' || $kelas === '') {
        echo "<option value=''>Data tidak valid</option>";
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT jm.mapel AS idmapel, mp.nama_mapel 
        FROM jadwal_mengajar jm
        LEFT JOIN mapel mp ON mp.id = jm.mapel
        WHERE jm.guru = ? AND jm.kelas = ?
        GROUP BY jm.mapel
    ");
    $stmt->execute([$guru, $kelas]);
    $mapelList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<option value=''>Pilih Mapel</option>";
    foreach ($mapelList as $m) {
        $idmapel = htmlspecialchars($m['idmapel']);
        $mapel   = htmlspecialchars($m['nama_mapel']);
        echo "<option value='{$idmapel}'>{$mapel}</option>";
    }
}

if ($pg === 'jumph') {
    $guru  = $_POST['guru'] ?? '';
    $kelas = $_POST['kelas'] ?? '';
    $mapel = $_POST['mapel'] ?? '';

    $stmt = $pdo->prepare("SELECT level FROM m_kelas WHERE kelas = ? LIMIT 1");
    $stmt->execute([$kelas]);
    $mpl = $stmt->fetch(PDO::FETCH_ASSOC);
    $tingkat = $mpl['level'] ?? '';

    $stmt = $pdo->prepare("
        SELECT COUNT(*) AS jumlah 
        FROM cp_elemen 
        WHERE tingkat = ? AND mapel = ? AND guru = ?
    ");
    $stmt->execute([$tingkat, $mapel, $guru]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $jumlah = $row['jumlah'] ?? 0;

    echo "<option value='$jumlah'>$jumlah</option>";
}

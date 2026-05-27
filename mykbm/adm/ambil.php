<?php
require("../../konek/koneksi.php"); 
$pg = $_GET['pg'] ?? '';

if ($pg === 'level') {
    $guru = $_POST['guru'] ?? '';

    $stmt = $pdo->prepare("
        SELECT DISTINCT k.level 
        FROM jadwal_mengajar j
        LEFT JOIN m_kelas k ON k.kelas = j.kelas
        WHERE j.guru = ?
    ");
    $stmt->execute([$guru]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<option value=''>Pilih Tingkat</option>";
    foreach ($rows as $kls) {
        $level = htmlspecialchars($kls['level'], ENT_QUOTES);
        echo "<option value='{$level}'>{$level}</option>";
    }
}

if ($pg === 'mapelguru') {
    $guru = $_POST['guru'] ?? '';

    $stmt = $pdo->prepare("
        SELECT DISTINCT m.id, m.nama_mapel
        FROM jadwal_mengajar j
        JOIN mapel m ON m.id = j.mapel
        WHERE j.guru = ?
    ");
    $stmt->execute([$guru]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<option value=''>Pilih Mapel</option>";
    foreach ($rows as $m) {
        $id   = htmlspecialchars($m['id'], ENT_QUOTES);
        $nama = htmlspecialchars($m['nama_mapel'], ENT_QUOTES);
        echo "<option value='{$id}'>{$nama}</option>";
    }
}
?>

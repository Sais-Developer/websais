<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");
$pg = $_GET['pg'] ?? '';

if ($pg == 'kelas') {
    $id_level = $_POST['tingkat'] ?? '';
    echo "<option value=''>Pilih Kelas</option>";

    $stmt = $pdo->prepare("SELECT level, kelas FROM m_kelas WHERE level = :level ORDER BY kelas ASC");
    $stmt->bindParam(':level', $id_level, PDO::PARAM_STR);
    $stmt->execute();

    $kelasList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($kelasList as $data) {
        echo "<option value='" . htmlspecialchars($data['kelas']) . "'>" . htmlspecialchars($data['kelas']) . "</option>";
    }
}

if ($pg == 'ambil_ruang') {
    echo "<option value=''>Pilih Ruang</option>";

    $stmt = $pdo->prepare("SELECT DISTINCT ruang FROM siswa ORDER BY ruang ASC");
    $stmt->execute();
    $ruangList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($ruangList as $ruang) {
        echo "<option value='" . htmlspecialchars($ruang['ruang']) . "'>" . htmlspecialchars($ruang['ruang']) . "</option>";
    }
}

if ($pg == 'ambilkelas') {
    $id_bank = $_POST['mapel_id'] ?? '';
    $ruang   = $_POST['ruang'] ?? '';
    $sesi    = $_POST['sesi'] ?? '';

    if (!$id_bank || !$ruang || !$sesi) {
        echo "<option value=''>Data tidak lengkap</option>";
        exit;
    }
    $stmt = $pdo->prepare("SELECT tingkat FROM banksoal WHERE id_bank = :id_bank LIMIT 1");
    $stmt->execute([':id_bank' => $id_bank]);
    $bank = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$bank) {
        echo "<option value=''>Bank soal tidak ditemukan</option>";
        exit;
    }
    $level = $bank['tingkat'];
    $stmt = $pdo->prepare("
        SELECT DISTINCT kelas 
        FROM siswa 
        WHERE ruang = :ruang AND sesi = :sesi AND level = :level
        ORDER BY kelas ASC
    ");
    $stmt->execute([
        ':ruang' => $ruang,
        ':sesi'  => $sesi,
        ':level' => $level
    ]);

    echo "<option value=''>Pilih Kelas</option>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . htmlspecialchars($row['kelas']) . "'>" . htmlspecialchars($row['kelas']) . "</option>";
    }
}


if ($pg == 'ambil_sesi') {
    $ruang = $_POST['ruang'] ?? '';
    echo "<option value=''>Pilih Sesi</option>";

    $stmt = $pdo->prepare("SELECT DISTINCT sesi FROM siswa WHERE ruang = :ruang ORDER BY sesi ASC");
    $stmt->bindParam(':ruang', $ruang, PDO::PARAM_STR);
    $stmt->execute();

    $sesiList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($sesiList as $sesi) {
        echo "<option value='" . htmlspecialchars($sesi['sesi']) . "'>" . htmlspecialchars($sesi['sesi']) . "</option>";
    }
}
?>

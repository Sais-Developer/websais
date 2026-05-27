<?php
require(__DIR__ . "/../../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';

if ($pg === 'dudi') {
    $kelas = $_POST['kelas'] ?? '';
    if (empty($kelas)) {
        echo "<option value=''>Pilih Dudi</option>";
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT p.dudi, d.nama_dudi
        FROM pkl_siswa p
        LEFT JOIN pkl_dudi d ON d.id = p.dudi
        WHERE p.kelas = ?
        GROUP BY p.kelas, p.dudi
    ");
    $stmt->execute([$kelas]);

    echo "<option value=''>Pilih Dudi</option>";

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($results) > 0) {
        foreach ($results as $k) {
            $dudiId = htmlspecialchars($k['dudi']);
            $namaDudi = htmlspecialchars($k['nama_dudi']);
            echo "<option value='{$dudiId}'>{$namaDudi}</option>";
        }
    } else {
        echo "<option value=''>Tidak ada kelas</option>";
    }
}

if ($pg === 'kompeten') {
    $kelas = $_POST['kelas'] ?? '';
    if (empty($kelas)) {
        echo "<option value=''>Data tidak valid</option>";
        exit;
    }

    $stmt = $pdo->prepare("
        SELECT p.*
        FROM pkl_kompetensi p
        LEFT JOIN m_kelas s ON s.jurusan = p.jurusan
        WHERE s.kelas = ?
    ");
    $stmt->execute([$kelas]);

    echo "<option value=''>Pilih Kompetensi</option>";

    while ($m = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $idk  = htmlspecialchars($m['id_kompetensi']);
        $kom  = htmlspecialchars($m['kompeten']);
        echo "<option value='{$idk}'>{$kom}</option>";
    }
}

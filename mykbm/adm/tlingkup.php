<?php
require("../../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';
$semester = $setting['semester'];

if ($pg === 'tambah') {
    $guru    = $_POST['guru'] ?? '';
    $mapel   = $_POST['mapel'] ?? '';
    $level   = $_POST['level'] ?? '';
    $lingkup = $_POST['lingkup'] ?? '';
    $tujuan  = $_POST['tujuan'] ?? '';

    $cek = $pdo->prepare("
        SELECT COUNT(*) 
        FROM adm_tp
        WHERE tingkat = ? AND mapel = ? AND lingkup = ? AND semester = ?
    ");
    $cek->execute([$level, $mapel, $lingkup, $semester]);
    $count = $cek->fetchColumn();

    if ($count == 0) {
        $insert = $pdo->prepare("
            INSERT INTO adm_tp (tingkat, lingkup, tujuan, mapel, guru, semester)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $insert->execute([$level, $lingkup, $tujuan, $mapel, $guru, $semester]);
    }
}

if ($pg === 'edit') {
    $id      = intval($_POST['id']);
    $lingkup = $_POST['lingkup'];
    $tujuan  = $_POST['tujuan'];

    $stmt = $pdo->prepare("
        UPDATE adm_tp 
        SET lingkup = ?, tujuan = ?
        WHERE id = ?
    ");
    $stmt->execute([$lingkup, $tujuan, $id]);
}

if ($pg === 'hapus') {
    $id = intval($_POST['id']);

    $stmt = $pdo->prepare("DELETE FROM adm_tp WHERE id = ?");
    $stmt->execute([$id]);
}
?>

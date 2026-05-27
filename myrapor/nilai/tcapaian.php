<?php
require("../../konek/koneksi.php");

$idsiswa  = $_POST['ids']     ?? '';
$nis  = $_POST['nis']     ?? '';
$mapel    = $_POST['mapel']   ?? '';
$kelas    = $_POST['kelas']   ?? '';
$guru     = $_POST['guru']    ?? '';
$semester = $_POST['smt']     ?? '';
$tapel    = $_POST['tp']      ?? '';
$nilai    = $_POST['nilai']   ?? '';
$rendah   = $_POST['rendah']  ?? '';
$tinggi   = $_POST['tinggi']  ?? '';
$ket      = 'PTS';

if ($rendah == $tinggi) {
    echo "GAGAL";  
} else {
    
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM nilai_capaian 
        WHERE idsiswa = ? AND idmapel = ? AND kelas = ? AND ket = ? AND semester = ? AND tapel = ?
    ");
    $stmt->execute([$idsiswa, $mapel, $kelas, $ket, $semester, $tapel]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        
        $stmt = $pdo->prepare("
            UPDATE nilai_capaian 
            SET nilai =?, rendah = ?, tinggi = ? 
            WHERE idsiswa = ? AND idmapel = ? AND kelas = ? AND ket = ? AND semester = ? AND tapel = ?
        ");
        $stmt->execute([$nilai, $rendah, $tinggi, $idsiswa, $mapel, $kelas, $ket, $semester, $tapel]);
        echo "SD"; 
    } else {
       
        $stmt = $pdo->prepare("
            INSERT INTO nilai_capaian 
            (idsiswa, nis, idmapel, kelas, guru, semester, tapel, nilai, rendah, tinggi, ket) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$idsiswa, $nis, $mapel, $kelas, $guru, $semester, $tapel, $nilai, $rendah, $tinggi, $ket]);
        echo "OK";  
    }
}

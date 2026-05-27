<?php
require("../konek/koneksi.php"); 
$server = $_POST['server'] ?? '';
$kode   = $_POST['kode'] ?? '';
$nama   = $_POST['nama'] ?? '';

$data = [
    'kode_server' => htmlspecialchars(trim($server), ENT_QUOTES, 'UTF-8'),
    'kode_ujian'  => htmlspecialchars(trim($kode), ENT_QUOTES, 'UTF-8'),
    'jenis_ujian' => htmlspecialchars(trim($nama), ENT_QUOTES, 'UTF-8')
];

$fields = array_keys($data);
$setStr = implode(", ", array_map(fn($f) => "$f = :$f", $fields));
$sql = "UPDATE pengaturan SET $setStr WHERE id_aplikasi = :id_aplikasi";

$stmt = $pdo->prepare($sql);
$data['id_aplikasi'] = 1;
$simpan = $stmt->execute($data);
?>

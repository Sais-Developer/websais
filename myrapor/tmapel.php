<?php
require("../konek/koneksi.php");

$idmapel    = $_POST['mapel'];
$tingkat    = $_POST['tingkat'];
$jurusan    = $_POST['jurusan'];
$idkelompok = $_POST['kelompok'];

$count = count($idmapel);

$sql = "INSERT INTO mapel_rapor (idmapel, tingkat, jurusan, kelompok) 
        VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

for ($i = 0; $i < $count; $i++) {
    $stmt->execute([
        $idmapel[$i],
        $tingkat[$i],
        $jurusan[$i],
        $idkelompok[$i]
    ]);
}

echo "Data berhasil disimpan.";

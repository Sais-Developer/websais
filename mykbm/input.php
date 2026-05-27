<?php
require("../konek/koneksi.php"); 

$tanggal = $_POST['tanggal'];
$ids     = $_POST['idsiswa'];
$kelas   = $_POST['kelas'];
$mapel   = $_POST['mapel'];
$guru    = $_POST['guru'];
$nilai   = $_POST['nilai'];

$smt   = $setting['semester'];
$tapel = $setting['tp'];

$sql = "INSERT INTO nilai_harian 
        (idsiswa, tanggal, kelas, mapel, nilai, guru, smt, tp) 
        VALUES (:idsiswa, :tanggal, :kelas, :mapel, :nilai, :guru, :smt, :tp)";

$stmt = $pdo->prepare($sql);

foreach ($ids as $i => $idSiswa) {

    if (empty($idSiswa) || empty($kelas[$i]) || empty($mapel[$i])) {
        continue;
    }

    $stmt->execute([
        ':idsiswa' => $idSiswa,
        ':tanggal' => $tanggal[$i],
        ':kelas'   => $kelas[$i],
        ':mapel'   => $mapel[$i],
        ':nilai'   => $nilai[$i],
        ':guru'    => $guru[$i],
        ':smt'     => $smt,
        ':tp'      => $tapel
    ]);
}

echo "Data nilai berhasil disimpan!";
?>

<?php
require("../../konek/koneksi.php");

$idsiswa  = $_POST['ids'] ?? '';
$nis  = $_POST['nis'] ?? '';
$ket      = $_POST['ket'] ?? '';
$semester = $setting['semester'];
$tapel    = $setting['tp'];
$rendah   = $_POST['rendah'] ?? '';
$tinggi   = $_POST['tinggi'] ?? '';

if ($rendah === $tinggi) {
    echo "GAGAL";
    exit;
}

try {
  
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM kokurikuler 
        WHERE idsiswa = :idsiswa AND keter = :keter AND smt = :semester AND tapel = :tapel
    ");
    $stmt->execute([
        ':idsiswa' => $idsiswa,
        ':keter'   => $ket,
        ':semester'=> $semester,
        ':tapel'   => $tapel
    ]);

    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "SD"; 
    } else {
       
        $insert = $pdo->prepare("
            INSERT INTO kokurikuler (idsiswa, nis, mampu, kurang, smt, tapel, keter)
            VALUES (:idsiswa, :nis, :mampu, :kurang, :semester, :tapel, :keter)
        ");
        $insert->execute([
            ':idsiswa' => $idsiswa,
			':nis' => $nis,
            ':mampu'   => $tinggi,
            ':kurang'  => $rendah,
            ':semester'=> $semester,
            ':tapel'   => $tapel,
            ':keter'   => $ket
        ]);

        echo "OK"; 
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

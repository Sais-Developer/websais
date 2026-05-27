<?php
require("../../konek/koneksi.php"); 

$idsiswa  = $_POST['ids']      ?? '';
$nis  = $_POST['nis']     ?? '';
$mapel    = $_POST['mapel']    ?? '';
$kelas    = $_POST['kelas']    ?? '';
$guru     = $_POST['guru']     ?? '';
$semester = $_POST['smt']      ?? '';
$tapel    = $_POST['tp']       ?? '';
$nilai    = $_POST['nilai']    ?? '';
$rendah   = $_POST['rendah']   ?? '';
$tinggi   = $_POST['tinggi']   ?? '';
$ket      = 'PAT';

if ($rendah == $tinggi) {
    echo "GAGAL";
    exit;
}

try {
    
    $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM nilai_capaian 
                                 WHERE idsiswa=:ids AND idmapel=:mapel AND kelas=:kelas 
                                   AND ket=:ket AND semester=:semester AND tapel=:tapel");
    $check_stmt->execute([
        ':ids' => $idsiswa,
        ':mapel' => $mapel,
        ':kelas' => $kelas,
        ':ket' => $ket,
        ':semester' => $semester,
        ':tapel' => $tapel
    ]);
    $count = $check_stmt->fetchColumn();

    if ($count > 0) {
        
        $update_stmt = $pdo->prepare("UPDATE nilai_capaian 
                                      SET nilai=:nilai, rendah=:rendah, tinggi=:tinggi
                                      WHERE idsiswa=:ids AND idmapel=:mapel AND kelas=:kelas 
                                        AND ket=:ket AND semester=:semester AND tapel=:tapel");
        $update_stmt->execute([
			':nilai' => $nilai,
            ':rendah' => $rendah,
            ':tinggi' => $tinggi,
            ':ids' => $idsiswa,
            ':mapel' => $mapel,
            ':kelas' => $kelas,
            ':ket' => $ket,
            ':semester' => $semester,
            ':tapel' => $tapel
        ]);
        echo "SD";
    } else {
        
        $insert_stmt = $pdo->prepare("INSERT INTO nilai_capaian 
            (idsiswa, nis, idmapel, kelas, guru, semester, tapel, nilai, rendah, tinggi, ket)
            VALUES (:ids, :nis, :mapel, :kelas, :guru, :semester, :tapel, :nilai, :rendah, :tinggi, :ket)");
        $insert_stmt->execute([
            ':ids' => $idsiswa,
			 ':nis' => $nis,
            ':mapel' => $mapel,
            ':kelas' => $kelas,
            ':guru' => $guru,
            ':semester' => $semester,
            ':tapel' => $tapel,
            ':nilai' => $nilai,
            ':rendah' => $rendah,
            ':tinggi' => $tinggi,
            ':ket' => $ket
        ]);
        echo "OK";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

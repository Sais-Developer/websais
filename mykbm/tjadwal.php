<?php
require("../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

if ($pg === 'hapus') {
    $id = $_POST['id'] ?? '';

    $stmt = $pdo->prepare("DELETE FROM jadwal_mengajar WHERE id_jadwal = ?");
    $result = $stmt->execute([$id]); 
}

if ($pg === 'tambah') {

    $ket    = $_POST['ket'] ?? '';
    $kelas  = $_POST['kelas'] ?? '';
    $mapel  = $_POST['mapel'] ?? '';
    $guru   = $_POST['guru'] ?? '';
    $hari   = $_POST['hari'] ?? '';
    $dari   = $_POST['dari'] ?? '';
    $sampai = $_POST['sampai'] ?? '';

    $selisih = strtotime($sampai) - strtotime($dari);
    $jam     = floor($selisih / 3600);
    $menit   = $selisih - ($jam * 3600);
    $detik   = $selisih % 60;
    $jjm     = (($jam * 60) + floor($menit / 60)) / $setting['jjm'];
    if ($ket === 'Guru') {

        $sqlCek = "
            SELECT COUNT(*) 
            FROM jadwal_mengajar 
            WHERE guru = ? 
              AND hari = ?
              AND (
                    (dari < ? AND sampai > ?)   -- tumpang tindih di tengah
                 OR (dari >= ? AND dari < ?)   -- mulai di tengah
                 OR (sampai > ? AND sampai <= ?) -- selesai di tengah
              )
        ";

        $cek_stmt = $pdo->prepare($sqlCek);
        $cek_stmt->execute([
            $guru, $hari,
            $sampai, $dari,
            $dari, $sampai,
            $dari, $sampai
        ]);

        $count = $cek_stmt->fetchColumn();
        if ($count == 0) {

            $sqlInsert = "
                INSERT INTO jadwal_mengajar 
                (kelas, mapel, guru, hari, dari, sampai, jjm)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ";

            $insert_stmt = $pdo->prepare($sqlInsert);
            $insert_stmt->execute([
                $kelas, $mapel, $guru, $hari, $dari, $sampai, $jjm
            ]);
        }

    } else {

        $cek_stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM jadwal_mengajar 
            WHERE hari = ? AND guru = ?
        ");

        $cek_stmt->execute([$hari, $guru]);
        $count = $cek_stmt->fetchColumn();

        if ($count == 0) {

            $sqlInsert = "
                INSERT INTO jadwal_mengajar 
                (guru, hari, dari, sampai, jjm)
                VALUES (?, ?, ?, ?, ?)
            ";

            $insert_stmt = $pdo->prepare($sqlInsert);
            $insert_stmt->execute([
                $guru, $hari, $dari, $sampai, $jjm
            ]);
        }
    }
}
?>

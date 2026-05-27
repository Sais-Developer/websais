<?php
require("../konek/koneksi.php");

$semester  = $_POST['smt']     ?? '';
$tapel     = $_POST['tapel']   ?? '';
$ket       = $_POST['ket']     ?? '';
$tanggal   = $_POST['tanggal'] ?? '';

try {
    $check_stmt = $pdo->prepare("
        SELECT COUNT(*) AS count 
        FROM tanggal_rapor 
        WHERE ket = ? AND semester = ? AND tapel = ?
    ");
    $check_stmt->execute([$ket, $semester, $tapel]);
    $count = $check_stmt->fetchColumn();

    if ($count > 0) {
        echo "GAGAL"; 
    } else {
        $insert_stmt = $pdo->prepare("
            INSERT INTO tanggal_rapor (tanggal, semester, tapel, ket) 
            VALUES (?, ?, ?, ?)
        ");
        $insert_stmt->execute([$tanggal, $semester, $tapel, $ket]);
        echo "OK";
    }
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}

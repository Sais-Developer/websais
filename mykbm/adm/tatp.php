<?php
require("../../konek/koneksi.php");

$pg = isset($_GET['pg']) ? $_GET['pg'] : '';

if ($pg == 'tambah') {
    $idel  = intval($_POST['idel']);
    $waktu = $_POST['waktu'];
    $stmtCount = $pdo->prepare("SELECT COUNT(ke) AS jml FROM cp_elemen WHERE ke IS NOT NULL");
    $stmtCount->execute();
    $countRow = $stmtCount->fetch(PDO::FETCH_ASSOC);
    $ke = $countRow['jml'] + 1;

    $stmtUpd = $pdo->prepare("UPDATE cp_elemen SET waktu = :waktu, ke = :ke WHERE id_elemen = :idel");
    $stmtUpd->bindParam(':waktu', $waktu, PDO::PARAM_INT);
    $stmtUpd->bindParam(':ke', $ke, PDO::PARAM_INT);
    $stmtUpd->bindParam(':idel', $idel, PDO::PARAM_INT);
    
    $result = $stmtUpd->execute();
    
    $stmtUpd = null; 
}

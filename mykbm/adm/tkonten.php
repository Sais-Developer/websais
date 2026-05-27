<?php
require("../../konek/koneksi.php");

$pg = isset($_GET['pg']) ? $_GET['pg'] : '';

if ($pg == 'tambah') {
    $idel      = $_POST['idel'];
    $ringkasan = $_POST['ringkasan'];
    $gambaran  = $_POST['gambaran'];
    $media     = $_POST['media'];
    $sumber    = $_POST['sumber'];
    $stmtUpd = $pdo->prepare("
        UPDATE cp_elemen 
        SET ringkasan = :ringkasan, gambaran = :gambaran, media = :media, sumber = :sumber
        WHERE id_elemen = :idel
    ");
    
    $stmtUpd->bindParam(':ringkasan', $ringkasan, PDO::PARAM_STR);
    $stmtUpd->bindParam(':gambaran', $gambaran, PDO::PARAM_STR);
    $stmtUpd->bindParam(':media', $media, PDO::PARAM_STR);
    $stmtUpd->bindParam(':sumber', $sumber, PDO::PARAM_STR);
    $stmtUpd->bindParam(':idel', $idel, PDO::PARAM_INT);
    
    $result = $stmtUpd->execute();
    if ($result) {
        
        echo "Record updated successfully.";
    } else {
     
        echo "Failed to update record.";
    }
    $stmtUpd = null;
}
?>

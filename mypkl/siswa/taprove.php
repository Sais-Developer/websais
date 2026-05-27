<?php
require("../../konek/koneksi.php"); 

$id     = $_POST['id'] ?? '';
$catat  = $_POST['catat'] ?? '';
$sts    = 1;

$sql = "UPDATE pkl_jurnal 
        SET catatan = :catatan, status = :status 
        WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':catatan' => $catat,
    ':status'  => $sts,
    ':id'      => $id
]);
?>

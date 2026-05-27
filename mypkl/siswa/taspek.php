<?php
require("../../konek/koneksi.php");

$id      = $_POST['id'] ?? '';
$aspek   = $_POST['aspek'] ?? '';
$deskrip = $_POST['deskrip'] ?? '';

if ($id != '') {
    $stmt = $pdo->prepare("UPDATE pkl_aspek SET nama_aspek = ?, deskripsi = ? WHERE id_aspek = ?");
    $stmt->execute([$aspek, $deskrip, $id]);

}
?>

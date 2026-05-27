<?php
require("../konek/koneksi.php"); // $db = PDO
$jjm   = $_POST['jjm'] ?? '';
$honor = $_POST['honor'] ?? '';

$query = "UPDATE pengaturan SET jjm = ?, honor = ? WHERE id_aplikasi = 1";
$stmt = $db->prepare($query);
$success = $stmt->execute([$jjm, $honor]);

echo $success ? "Data berhasil diupdate." : "Gagal mengupdate data.";
?>

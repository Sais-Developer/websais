<?php
require("../konek/koneksi.php"); 
$idu = $_POST['id'] ?? 0;

if (!$idu) {
    exit("ID tidak valid");
}

$stmt = $pdo->prepare("DELETE FROM ujian WHERE id_jadwal = ?");
if ($stmt->execute([$idu])) {
    echo "OK";
} else {
    echo "Gagal hapus data";
}
?>

<?php
require("../konek/koneksi.php"); 

$kode  = $_POST['id'] ?? 0;
$nilai = $_POST['nilai'] ?? 0;

$stmt = $pdo->prepare("UPDATE jawaban_tugas SET nilai = :nilai WHERE id_jawaban = :id");
$success = $stmt->execute([
    ':nilai' => $nilai,
    ':id'    => $kode
]);

if ($success) {
    echo "OK";
} else {
    echo "Gagal update.";
}
?>

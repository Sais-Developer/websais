<?php
require("../konek/koneksi.php"); 

$statusBaru = 1;
$statusLama = 0;

$stmt = $pdo->prepare("UPDATE pkl_jurnal SET status = :statusBaru WHERE status = :statusLama");
$stmt->execute([
    ':statusBaru' => $statusBaru,
    ':statusLama' => $statusLama
]);

$affectedRows = $stmt->rowCount();

if ($affectedRows > 0) {
    echo "Berhasil " . $affectedRows . " baris.";
} else {
    echo "No update.";
}

$pdo = null;
?>

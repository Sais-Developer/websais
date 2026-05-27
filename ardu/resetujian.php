<?php
require("../konek/koneksi.php"); 

$hapus = 1;

$stmt = $pdo->prepare("DELETE FROM nilai WHERE hapus = :hapus");
$stmt->execute([':hapus' => $hapus]);

$affectedRows = $stmt->rowCount();

if ($affectedRows > 0) {
    echo "Berhasil " . $affectedRows . " baris.";
} else {
    echo "Tidak ada data.";
}

$pdo = null;
?>

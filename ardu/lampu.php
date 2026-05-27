<?php
require("../konek/koneksi.php"); // pastikan $pdo adalah objek PDO

$status = '1';

$stmt = $pdo->prepare("SELECT id, status FROM lampu WHERE status = :status");
$stmt->execute([':status' => $status]);

while ($datax = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "L" . $datax['id'] . $datax['status'];
}

$pdo = null;
?>

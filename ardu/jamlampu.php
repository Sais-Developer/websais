<?php
require("../konek/koneksi.php"); 

$stmt = $pdo->prepare("SELECT status FROM lampu ORDER BY id ASC");
$stmt->execute();

$statusList = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $statusList[] = $row['status'];
}

echo implode(',', $statusList);
$pdo = null;
?>

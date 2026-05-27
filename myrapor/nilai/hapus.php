<?php
require("../../konek/koneksi.php");

$idu = $_POST['id'] ?? '';

try {
   
    $pdo->beginTransaction();
    $stmtDelete = $pdo->prepare("DELETE FROM kokurikuler WHERE idk = :idk");
    $stmtDelete->execute([':idk' => $idu]);
    $pdo->commit();

    echo "OK"; 
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
?>

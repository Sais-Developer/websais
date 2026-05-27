<?php
require("../konek/koneksi.php");

$idu = $_POST['id'] ?? '';

try {
    $pdo->beginTransaction();
    $stmtDelete = $pdo->prepare("DELETE FROM tanggal_rapor WHERE id = ?");
    $stmtDelete->execute([$idu]);

    $stmtSelect = $pdo->query("SELECT id FROM tanggal_rapor ORDER BY id ASC");
    $rows = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
    $no = 1;
    $updateStmt = $pdo->prepare("UPDATE tanggal_rapor SET id = ? WHERE id = ?");
    foreach ($rows as $data) {
        $updateStmt->execute([$no, $data['id']]);
        $no++;
    }
    $pdo->exec("ALTER TABLE tanggal_rapor AUTO_INCREMENT = $no");
    $pdo->commit();

    echo "OK";
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "ERROR: " . $e->getMessage();
}

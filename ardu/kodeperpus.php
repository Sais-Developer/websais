<?php
require("../konek/koneksi.php");
require("../konek/function.php");
require("../konek/crud.php");

$stmt = $pdo->query("SELECT * FROM statustrx LIMIT 1");
$status = $stmt->fetch(PDO::FETCH_ASSOC);
$pdo->exec("TRUNCATE tmpsis");

$nokartu = $_GET['nokartu'] ?? '';


$stmt = $pdo->prepare("SELECT * FROM datareg WHERE nokartu = :nokartu LIMIT 1");
$stmt->execute([':nokartu' => $nokartu]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    echo "TIDAK TERDAFTAR";
} else {
    $nama = $data['nama'] ?? '';

    if (($status['mode'] ?? '') == '1') {
        echo ($data['nada'] ?? '') . "#" . $nama . "#24";
    }

    if (($status['mode'] ?? '') == '2') {
        echo ($data['nada'] ?? '') . "#" . $nama . "#25";
    }

    $stmtInsert = $pdo->prepare("INSERT INTO tmpsis(nokartu) VALUES(:nokartu)");
    $stmtInsert->execute([':nokartu' => $nokartu]);
}

$pdo = null;
?>

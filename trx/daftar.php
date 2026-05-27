<?php
require("../konek/koneksi.php"); 
require("../konek/function.php");
require("../konek/crud.php");

$kartu = $_POST['uid'];

try {
    $pdo->exec("TRUNCATE TABLE tmpreg");
    $stmt = $pdo->prepare("SELECT nokartu FROM datareg WHERE nokartu = :kartu");
    $stmt->execute([':kartu' => $kartu]);
    $jsiswa = $stmt->rowCount();

    if ($jsiswa != 0) {
        echo "GAGAL";
    } else {
        $stmt = $pdo->prepare("INSERT INTO tmpreg(nokartu) VALUES(:kartu)");
        $stmt->execute([':kartu' => $kartu]);
        echo $kartu . "               ";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<?php
require("konek/koneksi.php");

try {
  
    $pdo->exec("TRUNCATE tmpface");
    $nokartu = $_GET['nokartu'];

    $stmt = $pdo->prepare("SELECT * FROM datareg WHERE nokartu = :nokartu");
    $stmt->bindParam(':nokartu', $nokartu, PDO::PARAM_STR);
    $stmt->execute();

    $cek = $stmt->rowCount();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cek == 0) {
        echo "TIDAK TERDAFTAR";
    } else {
        echo $data['nama'];
    }

    $stmt = $pdo->prepare("INSERT INTO tmpface (nokartu) VALUES (:nokartu)");
    $stmt->bindParam(':nokartu', $nokartu, PDO::PARAM_STR);
    $stmt->execute();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>

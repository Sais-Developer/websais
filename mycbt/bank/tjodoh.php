<?php
require("../../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';
$idb = $_POST['idbank'] ?? '';
$nomor = $_POST['nomor'] ?? '';

function exist_menjodohkan($pdo, $idb, $nomor, $kode) {
    $stmt = $pdo->prepare(
        "SELECT id FROM menjodohkan WHERE idbank = :idb AND nomor = :nomor AND kode = :kode LIMIT 1"
    );
    $stmt->bindParam(':idb', $idb, PDO::PARAM_INT);
    $stmt->bindParam(':nomor', $nomor, PDO::PARAM_INT);
    $stmt->bindParam(':kode', $kode, PDO::PARAM_STR);
    $stmt->execute();
    $ada = $stmt->rowCount() > 0;
    return $ada;
}

function insert_menjodohkan($pdo, $idb, $kode, $nomor, $warna) {
    $stmt = $pdo->prepare(
        "INSERT INTO menjodohkan (idbank, kode, nomor, warna) VALUES (:idb, :kode, :nomor, :warna)"
    );
    $stmt->bindParam(':idb', $idb, PDO::PARAM_INT);
    $stmt->bindParam(':kode', $kode, PDO::PARAM_STR);
    $stmt->bindParam(':nomor', $nomor, PDO::PARAM_INT);
    $stmt->bindParam(':warna', $warna, PDO::PARAM_STR);
    $stmt->execute();
}

function update_jawab($pdo, $idb, $nomor, $jawab) {
    $stmt = $pdo->prepare(
        "UPDATE menjodohkan SET jawab = :jawab WHERE idbank = :idb AND nomor = :nomor AND jawab IS NULL"
    );
    $stmt->bindParam(':jawab', $jawab, PDO::PARAM_STR);
    $stmt->bindParam(':idb', $idb, PDO::PARAM_INT);
    $stmt->bindParam(':nomor', $nomor, PDO::PARAM_INT);
    $stmt->execute();
}

function delete_reset($pdo, $idb, $nomor) {
    $stmt = $pdo->prepare(
        "DELETE FROM menjodohkan WHERE idbank = :idb AND nomor = :nomor"
    );
    $stmt->bindParam(':idb', $idb, PDO::PARAM_INT);
    $stmt->bindParam(':nomor', $nomor, PDO::PARAM_INT);
    $stmt->execute();
}

if (preg_match('/^JDH([1-5])$/', $pg, $match)) {
    $index = $match[1];  
    $warna = $_POST['warna'] ?? '';
    $kode  = "5.$index.$idb";

    if (!exist_menjodohkan($pdo, $idb, $nomor, $kode)) {
        insert_menjodohkan($pdo, $idb, $kode, $nomor, $warna);
    }
}

if ($pg === 'RESET') {
    delete_reset($pdo, $idb, $nomor);
}

if ($pg === 'UPJDH1') {
    $jawab = $_POST['jawab'] ?? '';
    update_jawab($pdo, $idb, $nomor, $jawab);
}
?>

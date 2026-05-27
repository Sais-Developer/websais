<?php
require '../../konek/koneksi.php'; 

$id     = $_POST['id'];
$lokasi = $_POST['lokasi'];
$ruang  = $_POST['ruang'];

try {
    $sql = "UPDATE sapras_ruangan 
            SET nama_ruangan = :ruang, lokasi = :lokasi 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':ruang', $ruang);
    $stmt->bindParam(':lokasi', $lokasi);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

} catch (PDOException $e) {
    echo "error: " . $e->getMessage();
}
?>

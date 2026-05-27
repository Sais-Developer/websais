<?php
declare(strict_types=1);
require("../konek/koneksi.php"); // pastikan ini berisi $pdo, bukan $koneksi

$cam = isset($_POST['webcam']) ? (int)$_POST['webcam'] : 0;

try {

    $sql = "UPDATE pengaturan 
            SET webcam = :cam
            WHERE id_aplikasi = 1";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cam', $cam, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Gagal memperbarui data.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

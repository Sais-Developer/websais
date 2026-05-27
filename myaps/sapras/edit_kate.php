<?php
require '../../konek/koneksi.php'; 

    $id = $_POST['id'];
    $kategori = $_POST['kategori'];

    try {
        $sql = "UPDATE sapras_kate SET kategori = :kategori WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':kategori', $kategori, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo 'success';
        } else {
            echo 'no_changes';
        }
    } catch (PDOException $e) {
        echo 'error: ' . $e->getMessage();
    }

?>

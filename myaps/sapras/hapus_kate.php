<?php
require '../../konek/koneksi.php'; 
    $id = $_POST['id'];

    $sql = "DELETE FROM sapras_kate WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $exec = $stmt->execute([":id" => $id]);
?>

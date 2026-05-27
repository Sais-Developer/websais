<?php
require '../../konek/koneksi.php'; 
    $id = $_POST['id'];

    $stmt = $pdo->prepare("SELECT foto FROM sapras WHERE id = :id");
    $stmt->execute([":id" => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "DELETE FROM sapras WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $exec = $stmt->execute([":id" => $id]);

    if ($exec) {
        if ($data['foto'] && file_exists("../../images/sapras/" . $data['foto'])) {
            unlink("../../images/sapras/" . $data['foto']);
        }
        echo "Data berhasil dihapus!";
    } else {
        echo "Gagal menghapus data!";
    }

?>

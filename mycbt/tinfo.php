<?php
require("../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';

if ($pg == 'hapus') {
    $id = $_POST['id'] ?? '';

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM pengumuman WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if ($pg == 'simpan') {
    $judul = $_POST['judul'] ?? '';
    $isi = $_POST['isi'] ?? '';

    if ($judul && $isi) {
        $stmt = $pdo->prepare("INSERT INTO pengumuman (judul, isi) VALUES (:judul, :isi)");
        $stmt->bindValue(':judul', $judul, PDO::PARAM_STR);
        $stmt->bindValue(':isi', $isi, PDO::PARAM_STR);
        $stmt->execute();
    }
}
?>

<?php
require("../../konek/koneksi.php");
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';

if ($pg === 'tambah') {
    $kode = $_POST['eskul'] ?? '';
    $guru = $_POST['guru'] ?? '';

    if ($kode && $guru) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM m_eskul WHERE eskul = :eskul AND guru = :guru");
        $stmt->execute(['eskul' => $kode, 'guru' => $guru]);
        $cek = $stmt->fetchColumn();

        if ($cek > 0) {
            echo "0"; 
        } else {
            $stmt = $db->prepare("INSERT INTO m_eskul (eskul, guru) VALUES (:eskul, :guru)");
            $exec = $stmt->execute(['eskul' => $kode, 'guru' => $guru]);
            echo $exec ? "1" : "0";
        }
    } else {
        echo "0"; 
    }
}

if ($pg === 'hapus') {
    $id = $_POST['id'] ?? '';

    if ($id) {
        $stmt = $db->prepare("DELETE FROM m_eskul WHERE id = :id");
        $exec = $stmt->execute(['id' => $id]);
        echo $exec ? "1" : "0";
    } else {
        echo "0";
    }
}
?>

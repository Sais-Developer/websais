<?php
require("../../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';

if ($pg === 'hapus') {
    $id = $_POST['id'] ?? '';

    if ($id !== '') {
        $stmt = $pdo->prepare("DELETE FROM pkl_dudi WHERE id = ?");
        $stmt->execute([$id]);
        $stmt = null;
    }
}

if ($pg === 'tambah') {
    $iddudi  = $_POST['iddudi'] ?? '';
    $dudi    = $_POST['dudi'] ?? '';
    $alamat  = $_POST['alamat'] ?? '';
    $telp    = $_POST['telp'] ?? '';
    $pembina = $_POST['pembina'] ?? '';

    $cek_stmt = $pdo->prepare("SELECT COUNT(*) FROM pkl_dudi WHERE nama_dudi = ?");
    $cek_stmt->execute([$dudi]);
    $count = $cek_stmt->fetchColumn();
    $cek_stmt = null;

    if ($count == 0) {
        $insert_stmt = $pdo->prepare("INSERT INTO pkl_dudi (nama_dudi, alamat, telp, instruktur) VALUES (?, ?, ?, ?)");
        $insert_stmt->execute([$dudi, $alamat, $telp, $pembina]);
        $insert_stmt = null;
    } else {

        if ($iddudi !== '') {
            $update_stmt = $pdo->prepare("UPDATE pkl_dudi SET nama_dudi = ?, alamat = ?, telp = ?, instruktur = ? WHERE id = ?");
            $update_stmt->execute([$dudi, $alamat, $telp, $pembina, $iddudi]);
            $update_stmt = null;
        }
    }
}
?>

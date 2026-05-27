<?php
require("../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

if ($pg == 'hapus') {
    $id = $_POST['id'] ?? '';

    $stmt = $pdo->prepare("DELETE FROM nilai WHERE id_nilai = ?");
    $stmt->execute([$id]);
}

if ($pg == 'ulang') {
    $id = $_POST['id'] ?? '';

    $stmt = $pdo->prepare("SELECT id_bank, id_siswa FROM nilai WHERE id_nilai = ?");
    $stmt->execute([$id]);
    $nilai = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($nilai) {
        $id_bank  = $nilai['id_bank'];
        $id_siswa = $nilai['id_siswa'];

       
        $stmt_del_arsip = $pdo->prepare(
            "DELETE FROM arsip_jawaban WHERE id_siswa = ? AND id_bank = ?"
        );
        $stmt_del_arsip->execute([$id_siswa, $id_bank]);

        $stmt_del_nilai = $pdo->prepare("DELETE FROM nilai WHERE id_nilai = ?");
        $stmt_del_nilai->execute([$id]);
    }
}
?>

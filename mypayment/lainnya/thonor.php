<?php
require("../../konek/koneksi.php"); // pastikan $pdo adalah objek PDO

$pg = $_GET['pg'] ?? '';

if ($pg == 'gaji') {
    $idpeg = $_POST['guru'] ?? null;
    $tugas = $_POST['tugas'] ?? null;
    $besar = $_POST['besar'] ?? null;

    if (empty($idpeg) || empty($tugas) || empty($besar)) {
        die("Semua field harus diisi.");
    }

    $duit = filter_var($besar, FILTER_SANITIZE_NUMBER_INT);

    $stmt = $pdo->prepare("INSERT INTO pay_lain (idpeg, tugas, besar) VALUES (:idpeg, :tugas, :besar)");
    $stmt->execute([
        ':idpeg' => $idpeg,
        ':tugas' => $tugas,
        ':besar' => $duit
    ]);

    echo "OK";
}

if ($pg == 'hapus') {
    $id = $_POST['id'] ?? 0;

    if ($id <= 0) {
        die("ID tidak valid.");
    }

    $stmt = $pdo->prepare("DELETE FROM pay_lain WHERE id_lain = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        echo "OK";
    } else {
        echo "Kosong";
    }
}
?>

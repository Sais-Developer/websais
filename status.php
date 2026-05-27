<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "konek/koneksi.php";   
require "konek/function.php";

$pg = $_GET['pg'] ?? '';

if ($pg == 'ulangujian') {

    $id_bank  = $_POST['idb'] ?? '';
    $ids      = $_POST['ids'] ?? '';

    // cek parameter
    if (empty($id_bank) || empty($ids)) {
        $missing = [];
        if (empty($id_bank)) $missing[] = 'idb';
        if (empty($ids)) $missing[] = 'ids';

        echo json_encode([
            'status' => 'error',
            'message' => 'Parameter kosong: ' . implode(', ', $missing)
        ]);
        exit;
    }

    try {
       
        $pdo->beginTransaction();

        $sql1 = "DELETE FROM nilai WHERE id_siswa = :id_siswa AND id_bank = :id_bank";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute([
            ':id_siswa' => $ids,
            ':id_bank'  => $id_bank
        ]);

        $sql2 = "DELETE FROM jawaban WHERE id_siswa = :id_siswa AND id_bank = :id_bank";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([
            ':id_siswa' => $ids,
            ':id_bank'  => $id_bank
        ]);
        $pdo->commit();

        echo json_encode(['status' => 'success', 'message' => 'Jawaban dan nilai berhasil dihapus.']);

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

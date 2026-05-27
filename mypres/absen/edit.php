<?php
require("../../konek/koneksi.php"); // $db = PDO

$pg = $_GET['pg'] ?? '';

if ($pg === 'pegawai' || $pg === 'siswa') {
    $id  = $_POST['id']  ?? null;
    $ket = $_POST['ket'] ?? null;

    if ($id !== null && $ket !== null) {
        try {
            $stmt = $db->prepare("UPDATE absensi SET ket = :ket WHERE id = :id");
            $stmt->execute([
                ':ket' => $ket,
                ':id'  => $id
            ]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 1, 'message' => 'Berhasil diupdate']);
            } else {
                echo json_encode(['status' => 0, 'message' => 'Data tidak berubah']);
            }
        } catch (PDOException $e) {
            echo json_encode(['status' => 0, 'message' => 'Error: '.$e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 0, 'message' => 'Data tidak lengkap']);
    }
} else {
    echo json_encode(['status' => 0, 'message' => 'PG tidak valid']);
}
?>

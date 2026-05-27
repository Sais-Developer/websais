<?php
require("../konek/koneksi.php"); 

$kode = $_POST['id'] ?? 0;

$stmt = $pdo->prepare("SELECT file FROM jawaban_tugas WHERE id_jawaban = ?");
$stmt->execute([$kode]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null;

if ($data && !empty($data['file'])) {
    $filepath = "../tugas/" . $data['file'];
    if (is_file($filepath)) {
        unlink($filepath);
    }
}

$stmt = $pdo->prepare("DELETE FROM jawaban_tugas WHERE id_jawaban = ?");
if ($stmt->execute([$kode])) {
    echo "OK";
} else {
    echo "Gagal hapus data";
}
$stmt = null;
?>

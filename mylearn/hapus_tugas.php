<?php
require("../konek/koneksi.php"); 

$kode = $_POST['id'];

$stmt = $pdo->prepare("SELECT file FROM tugas WHERE id_tugas = ?");
$stmt->execute([$kode]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = null;

if ($data && !empty($data['file'])) {
    $file_path = "../tugas/" . $data['file'];
    if (is_file($file_path)) {
        unlink($file_path);
    }
}

$stmt = $pdo->prepare("DELETE FROM tugas WHERE id_tugas = ?");
$stmt->execute([$kode]);
$stmt = null;

$stmt = $pdo->prepare("DELETE FROM jawaban_tugas WHERE id_tugas = ?");
$stmt->execute([$kode]);
$stmt = null;

echo "OK";
?>

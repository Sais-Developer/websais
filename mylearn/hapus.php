<?php
require("../konek/koneksi.php");

$kode = $_POST['id'] ?? '';

if (!$kode) {
    exit("ID tidak valid");
}

$query = "SELECT file FROM materi WHERE idm = :idm";
$stmt = $pdo->prepare($query);
$stmt->execute([':idm' => $kode]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data && !empty($data['file'])) {
    $file_path = "../materi/" . $data['file'];
    if (is_file($file_path)) {
        unlink($file_path);
    }
}

$stmt = $pdo->prepare("DELETE FROM materi WHERE idm = :idm");
$stmt->execute([':idm' => $kode]);

$stmt = $pdo->prepare("DELETE FROM komentar WHERE idm = :idm");
$stmt->execute([':idm' => $kode]);

$stmt = $pdo->prepare("DELETE FROM absen_daringmapel WHERE idmateri = :idm");
$stmt->execute([':idm' => $kode]);

echo "OK";
?>

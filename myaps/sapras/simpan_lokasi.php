<?php
require '../../konek/koneksi.php';  

$ruang = $_POST['ruang'];
$lokasi = $_POST['lokasi'];

if (!$ruang) {
    echo "Input kosong!";
    exit;
}
$stmt = $pdo->prepare("INSERT INTO sapras_ruangan (nama_ruangan, lokasi) VALUES (:ruang, :lokasi)");
if ($stmt->execute([':ruang' => $ruang, 'lokasi' => $lokasi])) {
    echo "success";
} else {
    echo "error";
}
?>

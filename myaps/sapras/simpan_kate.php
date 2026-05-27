<?php
require '../../konek/koneksi.php';  

$kategori = $_POST['kategori'];

if (!$kategori) {
    echo "Input kosong!";
    exit;
}
$stmt = $pdo->prepare("INSERT INTO sapras_kate (kategori) VALUES (:kategori)");
if ($stmt->execute([':kategori' => $kategori])) {
    echo "success";
} else {
    echo "error";
}
?>

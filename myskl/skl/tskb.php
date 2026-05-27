<?php
require("../../konek/koneksi.php"); // harus berisi $pdo

$header = $_POST['header'];
$nosurat = $_POST['nosurat'];
$isi     = $_POST['isi'];
$foter   = $_POST['foter'];

$id = 1;

$sql = "UPDATE skkb 
        SET header = :header,
            nosurat = :nosurat,
            isi = :isi,
            foter = :foter
        WHERE id = :id";

$stmt = $pdo->prepare($sql);

$success = $stmt->execute([
    ':header' => $header,
    ':nosurat' => $nosurat,
    ':isi' => $isi,
    ':foter' => $foter,
    ':id' => $id
]);

if ($success) {
    echo "Data berhasil diperbarui.";
} else {
    echo "Gagal memperbarui data.";
}
?>

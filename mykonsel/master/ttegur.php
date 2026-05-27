<?php
require("../../konek/koneksi.php"); 

$id     = $_POST['id'];
$min    = $_POST['minpoin'];
$max    = $_POST['maxpoin'];
$jenis  = $_POST['jenis'];
$keter  = $_POST['keter'];

$stmt = $pdo->prepare("
    UPDATE teguran 
    SET 
        min_poin      = :minp,
        max_poin      = :maxp,
        jenis_teguran = :jenis,
        keterangan    = :keter
    WHERE id_teguran = :id
");

$stmt->execute([
    'minp'  => $min,
    'maxp'  => $max,
    'jenis' => $jenis,
    'keter' => $keter,
    'id'    => $id
]);

echo "sukses";
?>

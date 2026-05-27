<?php
require("../../konek/koneksi.php");

$teguran = $_POST['teguran'];
$idsiswa = $_POST['ids'];
$poin    = $_POST['poin'];
$catat   = $_POST['catat'];
$tindak  = $_POST['tindak'];
$tanggal = date('Y-m-d');

$stmt2 = $pdo->prepare("
    INSERT INTO konseling (idsiswa, tanggal, total_poin, teguran, catatan, tindakan_lanjutan)
    VALUES (:idsiswa, :tanggal, :poin, :teguran, :catat, :tindak)
");
$stmt2->execute([
    'idsiswa' => $idsiswa,
    'tanggal' => $tanggal,
    'poin'    => $poin,
    'teguran' => $teguran,
    'catat'   => $catat,
    'tindak'  => $tindak
]);
$stmt2 = null;

$zero = 0;
$update = $pdo->prepare("
    UPDATE siswa 
    SET total_poin = :zero, id_teguran = NULL 
    WHERE id_siswa = :idsiswa
");
$update->execute(['zero' => $zero, 'idsiswa' => $idsiswa]);
$update = null;

$one = 1;
$update2 = $pdo->prepare("
    UPDATE catatan_pelanggaran 
    SET status = :one
    WHERE id_siswa = :idsiswa
");
$update2->execute(['one' => $one, 'idsiswa' => $idsiswa]);
$update2 = null;
?>

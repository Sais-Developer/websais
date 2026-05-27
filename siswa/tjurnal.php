<?php
require("../konek/koneksi.php"); 

$idsiswa  = $_POST['ids'];
$kelas    = $_POST['kelas'];
$idk      = $_POST['idk'];
$dudi     = $_POST['dudi'];
$kegiatan = $_POST['proses'];

$tanggal = date('Y-m-d'); 

$sql = "INSERT INTO pkl_jurnal (idsiswa, kelas, dudi, tanggal, idk, jurnal) 
        VALUES (:idsiswa, :kelas, :dudi, :tanggal, :idk, :jurnal)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':idsiswa' => $idsiswa,
    ':kelas'   => $kelas,
    ':dudi'    => $dudi,
    ':tanggal' => $tanggal,
    ':idk'     => $idk,
    ':jurnal'  => $kegiatan
]);
?>

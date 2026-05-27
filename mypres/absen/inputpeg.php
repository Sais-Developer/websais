<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

$tanggalmu = date('Y-m-d');

$tanggal = $_POST['tanggal'] ?? [];
$bulan   = $_POST['bulan']   ?? [];
$tahun   = $_POST['tahun']   ?? [];
$ket     = $_POST['ket']     ?? [];
$ids     = $_POST['idguru']  ?? [];
$level   = $_POST['level']   ?? [];

if (!empty($ids)) {
    $sql = "INSERT INTO absensi(idpeg,tanggal,level,ket,bulan,tahun)
            VALUES (:idpeg,:tanggal,:level,:ket,:bulan,:tahun)";
    $stmt = $db->prepare($sql);
     foreach ($ids as $i => $id) {
        $tgl   = $tanggal[$i] ?? '';
        $lvl   = $level[$i] ?? '';
        $bln   = $bulan[$i] ?? '';
        $thn   = $tahun[$i] ?? '';
        $keterangan = $ket[$id] ?? 'A';
        
        $stmt->execute([
            ':idpeg' => $id,
            ':tanggal' => $tgl,
            ':level'   => $lvl,
            ':ket'     => $keterangan,
            ':bulan'   => $bln,
            ':tahun'   => $thn
        ]);
    }
    echo "1";
} else {
    echo "0";
}

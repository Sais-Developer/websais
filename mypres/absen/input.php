<?php
require("../../konek/koneksi.php"); // $db = PDO

$tanggalmu = date('Y-m-d');

$ids     = $_POST['idsiswa'] ?? [];
$tanggal = $_POST['tanggal'] ?? [];
$bulan   = $_POST['bulan']   ?? [];
$tahun   = $_POST['tahun']   ?? [];
$kelas   = $_POST['kelas']   ?? [];
$level   = $_POST['level']   ?? [];
$ket     = $_POST['ket']     ?? [];

$mapKet = [
    'I' => 'IZIN',
    'A' => 'ALPHA',
    'S' => 'SAKIT',
    'H' => 'HADIR'
];

if (!empty($ids)) {
    $sql = "INSERT INTO absensi(idsiswa,tanggal,kelas,level,ket,bulan,tahun)
            VALUES (:idsiswa,:tanggal,:kelas,:level,:ket,:bulan,:tahun)";
    $stmt = $db->prepare($sql);

    foreach ($ids as $i => $id) {
        $tgl   = $tanggal[$i] ?? '';
        $kls   = $kelas[$i] ?? '';
        $lvl   = $level[$i] ?? '';
        $bln   = $bulan[$i] ?? '';
        $thn   = $tahun[$i] ?? '';
        $keterangan = $ket[$id] ?? 'A';
        
        $stmt->execute([
            ':idsiswa' => $id,
            ':tanggal' => $tgl,
            ':kelas'   => $kls,
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

<?php
require("../konek/koneksi.php");
require("../konek/function.php");
require("../konek/crud.php");

$tahun = date('Y');
$kartu = $_POST['uid'];

$bulane = fetch('bulan', ['bln' => $bulan]); 

try {
  
    $stmt = $pdo->prepare("
        SELECT d.*, s.id_siswa, s.saldo, s.nama, s.kelas, s.nowa
        FROM datareg d
        LEFT JOIN siswa s ON s.id_siswa = d.idsiswa
        WHERE d.nokartu = :kartu
    ");
    $stmt->execute([':kartu' => $kartu]);
    $siswa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$siswa) {
        echo "GAGAL";
        exit;
    }
    $nowa = $siswa['nowa'];
    $ids = $siswa['id_siswa'];

    echo "      SMK SADAM CISURUPAN       \n";
    echo "  Jalan Serang RT. 006 RW. 005  \n";
    echo "================================\n";
    echo "        CETAK TRANSAKSI         \n\n";  
    echo "Nama   : " . substr($siswa['nama'], 0, 22) . "\n";
    echo "Kelas  : " . $siswa['kelas'] . "\n";
    echo "Bulan  : " . $bulane['ket'] . " " . $tahun . "\n";
    echo "================================\n";
    echo "TANGGAL     DEBET     KREDIT  \n";

    $stmtSaldo = $pdo->prepare("SELECT * FROM saldo WHERE idsiswa = :ids");
    $stmtSaldo->execute([':ids' => $ids]);
    $riwayat = $stmtSaldo->fetchAll(PDO::FETCH_ASSOC);

    foreach ($riwayat as $data) {
        echo $data['tanggal'] . " " . number_format($data['debet']) . "    " . number_format($data['kredit']) . "\n";
    }

    echo "================================\n";
    echo "Saldo  : RP " . number_format($siswa['saldo']) . "\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

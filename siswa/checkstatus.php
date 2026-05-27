<?php
header('Content-Type: application/json');
include "../konek/koneksi.php"; // pastikan ini menghasilkan $pdo, bukan $koneksi

$ids = $_GET['nama'] ?? '';
$tanggal = date('Y-m-d');

$sql = "
    SELECT p.*, j.*
    FROM pkl_presensi p
    LEFT JOIN pkl_jurnal j 
        ON j.idsiswa = p.idsiswa 
       AND j.tanggal = p.tanggal
    WHERE p.idsiswa = :ids AND p.tanggal = :tanggal
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':ids' => $ids,
    ':tanggal' => $tanggal
]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'absenMasuk' => !empty($row['foto']),
    'jurnal'     => !empty($row['jurnal']),
    'upload'     => !empty($row['foto_jurnal']),
    'ttd'        => !empty($row['ttd']),
    'absenPulang'=> !empty($row['pulang'])
]);
?>

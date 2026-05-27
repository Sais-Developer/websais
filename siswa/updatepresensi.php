<?php
require("../konek/koneksi.php"); // koneksi PDO
header('Content-Type: application/json');

$idsiswa = $_POST['idsiswa'] ?? '';
$tanggal = date('Y-m-d');
$pulang  = date('H:i:s');

if (!empty($idsiswa)) {
    $sql = "UPDATE pkl_presensi SET pulang = :pulang WHERE idsiswa = :idsiswa AND tanggal = :tanggal";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        ':pulang'  => $pulang,
        ':idsiswa' => $idsiswa,
        ':tanggal' => $tanggal
    ]);

    if ($success) {
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Jam pulang berhasil tercatat!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tidak ada data yang diupdate!']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengeksekusi query!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Data tidak valid!']);
}
?>

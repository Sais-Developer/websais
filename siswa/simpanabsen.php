<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
include "../konek/koneksi.php"; // harus menghasilkan variabel $pdo

$ids     = $_POST['nama'] ?? '';
$tanggal = $_POST['tanggal'] ?? date('Y-m-d');
$foto    = $_POST['foto'] ?? '';
$jam     = date('H:i:s');

if (!$ids || !$foto) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

$folder = __DIR__ . '/../images/prakerin/';
if (!is_dir($folder)) mkdir($folder, 0777, true);

$namaFile  = preg_replace('/\s+/', '_', $ids) . ".png";
$filePath  = $folder . $namaFile;
$fileForDB = "../images/prakerin/" . $namaFile;

if (file_exists($filePath)) unlink($filePath);
list(, $data) = explode(',', $foto);
if (file_put_contents($filePath, base64_decode($data)) === false) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan foto']);
    exit;
}
$masuk = 1;

$sql = "INSERT INTO pkl_presensi (idsiswa, tanggal, foto, masuk) 
        VALUES (:idsiswa, :tanggal, :foto, :masuk)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':idsiswa' => $ids,
    ':tanggal' => $tanggal,
    ':foto'    => $namaFile,
    ':masuk'   => $masuk
]);

echo json_encode(['status' => 'success', 'message' => 'Presensi berhasil disimpan']);

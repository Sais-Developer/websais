<?php
require("../konek/koneksi.php"); 

$ids      = $_POST['ids'] ?? '';
$guru     = $_POST['guru'] ?? '';
$catat    = $_POST['catat'] ?? '';
$sig_data = $_POST['signature'] ?? '';
$tanggal  = date("Y-m-d");

if (!$ids || !$sig_data) {
    echo json_encode(['status'=>'error','message'=>'Data tidak lengkap']);
    exit;
}


$folder = "../images/ttd";
if (!is_dir($folder)) mkdir($folder, 0755, true);

$filename = "ttd_" . date("His") . "_{$ids}.png";
$path = $folder . "/" . $filename;

if (preg_match('/^data:image\/(\w+);base64,/', $sig_data, $type)) {
    $data = substr($sig_data, strpos($sig_data, ',') + 1);
    $data = base64_decode($data);
    if ($data === false) {
        echo json_encode(['status'=>'error','message'=>'Gagal decode base64']);
        exit;
    }
    if (file_put_contents($path, $data) === false) {
        echo json_encode(['status'=>'error','message'=>'Gagal menyimpan file ttd']);
        exit;
    }
} else {
    echo json_encode(['status'=>'error','message'=>'Format signature tidak valid']);
    exit;
}

$sql = "UPDATE pkl_jurnal 
        SET ttd = :ttd, catatan = :catatan, pembina = :pembina 
        WHERE idsiswa = :idsiswa AND tanggal = :tanggal";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':ttd'     => $filename,
    ':catatan' => $catat,
    ':pembina' => $guru,
    ':idsiswa' => $ids,
    ':tanggal' => $tanggal
]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["status" => "success", "file" => $filename]);
} else {
    echo json_encode(["status" => "error", "message" => "Tidak ada data yang diupdate. Pastikan idsiswa dan tanggal sesuai di DB"]);
}
?>

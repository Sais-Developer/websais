<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

$neuralFile = '../../neural.json';
if (file_exists($neuralFile)) {
    unlink($neuralFile);
}

$from = '../../json/neural.json';
$to = '../../neural.json';
if (file_exists($from)) {
    copy($from, $to);
}

$query = $koneksi->prepare("SELECT folder FROM datareg");
$query->execute();
$result = $query->get_result();

while ($data = $result->fetch_assoc()) {
    $folderPath = '../../data/' . ($data['folder'] ?? '');
    if (is_dir($folderPath)) {
        $gambar = glob($folderPath . '/*');
        foreach ($gambar as $filex) {
            if (is_file($filex)) {
                unlink($filex);
            }
        }
        rmdir($folderPath);
    }
}
$query->close();

$stmt = $koneksi->prepare("UPDATE siswa SET sts='0'");
$stmt->execute();
$stmt->close();

$stmt = $koneksi->prepare("UPDATE guru SET sts='0'");
$stmt->execute();
$stmt->close();

$stmt = $koneksi->prepare("TRUNCATE TABLE datareg");
$stmt->execute();
$stmt->close();

$stmt = $koneksi->prepare("TRUNCATE TABLE tmpface");
$stmt->execute();
$stmt->close();

$koneksi->close();
?>

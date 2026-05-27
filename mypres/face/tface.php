<?php
require("../../konek/koneksi.php");

$id = $_POST['id'] ?? null;
if (!$id) {
    exit(json_encode(['error' => 'ID tidak ditemukan']));
}

$stmt = $pdo->prepare("SELECT * FROM datareg WHERE id = :id");
$stmt->execute(['id' => $id]);
$reg = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reg) {
    exit(json_encode(['error' => 'Data tidak ditemukan']));
}
if ($reg['level'] === 'siswa') {
    $stmt = $pdo->prepare("UPDATE siswa SET sts = '0' WHERE id_siswa = :id_siswa");
    $stmt->execute(['id_siswa' => $reg['idsiswa']]);
} elseif ($reg['level'] === 'pegawai') {
    $stmt = $pdo->prepare("UPDATE guru SET sts = '0' WHERE id_guru = :id_guru");
    $stmt->execute(['id_guru' => $reg['idpeg']]);
}

$folderPath = '../../data/' . $reg['folder'];
if (is_dir($folderPath)) {
    $files = glob($folderPath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    rmdir($folderPath);
}

$jsonFile = '../../neural.json';
if (file_exists($jsonFile)) {
    $jsonData = json_decode(file_get_contents($jsonFile), true);
    if (is_array($jsonData)) {
        $jsonData = array_filter($jsonData, function ($item) use ($reg) {
            return !str_starts_with($item['_label'] ?? '', $reg['folder']);
        });
        $jsonData = array_values($jsonData); // Reindex array
        file_put_contents($jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));
    }
}

$stmt = $pdo->prepare("DELETE FROM datareg WHERE id = :id");
$stmt->execute(['id' => $id]);

echo json_encode(['success' => true]);
?>

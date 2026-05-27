<?php
require __DIR__ . "/../../konek/koneksi.php";  
require __DIR__ . "/../../konek/function.php";

$idb = $_POST['idzip'] ?? null;
if (!$idb) {
    die('ID bank tidak diberikan.');
}

$files_to_zip = [];

try {
    // Ambil file dari database menggunakan PDO
    $stmt = $pdo->prepare("SELECT fileSoal, fileA, fileB, fileC, fileD, fileE FROM soal WHERE id_bank = :id_bank");
    $stmt->bindValue(':id_bank', $idb, PDO::PARAM_INT);
    $stmt->execute();
    $soalList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($soalList as $soal) {
        $fields = ['fileSoal','fileA','fileB','fileC','fileD','fileE'];
        foreach ($fields as $f) {
            if (!empty($soal[$f])) {
                $path = __DIR__ . '/../../files/' . $soal[$f];
                if (file_exists($path)) {
                    echo "Found: $path <br>";
                    $files_to_zip[basename($soal[$f])] = $path;
                } else {
                    echo "File not found: $path <br>";
                }
            }
        }
    }

    if (!empty($files_to_zip)) {
        $zip_file = __DIR__ . '/../../' . $idb . '.zip';
        $zip = new ZipArchive();
        if ($zip->open($zip_file, ZipArchive::CREATE) === TRUE) {
            foreach ($files_to_zip as $name => $fullpath) {
                $zip->addFile($fullpath, $name);
            }
            $zip->close();
            echo 'ZIP created: ' . $zip_file;
        } else {
            echo 'Gagal membuat ZIP';
        }
    } else {
        echo 'Tidak ada file untuk di-ZIP';
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

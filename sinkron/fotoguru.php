<?php
require("../konek/koneksi.php"); 
require("../konek/function.php");

$token = $_GET['token'] ?? 'false';

try {
    $stmt = $pdo->prepare("SELECT token_api FROM pengaturan WHERE token_api = ?");
    $stmt->execute([$token]);
    if ($stmt->rowCount() == 0) {
        echo json_encode(["status" => false, "msg" => "Token tidak valid"]);
        exit;
    }
    $sourceDir = __DIR__ . "/../images/fotoguru";

    if (!is_dir($sourceDir)) {
        echo json_encode(["status" => false, "msg" => "Folder sumber tidak ada"]);
        exit;
    }
    $zipFile = __DIR__ . "/../images/fotoguru.zip";
    $imagesDir = __DIR__ . "/../images";
    if (!is_dir($imagesDir)) mkdir($imagesDir, 0777, true);

    $zip = new ZipArchive();
    $res = $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    if ($res === TRUE) {
        $files = glob($sourceDir . "/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        if (empty($files)) {
            echo json_encode(["status" => false, "msg" => "Tidak ada file foto di folder"]);
            exit;
        }
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
        echo json_encode(["status" => true, "zip" => "images/fotoguru.zip"]);
    } else {
        echo json_encode(["status" => false, "msg" => "Gagal membuat zip, kode error: $res"]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status" => false,
        "msg" => $e->getMessage()
    ]);
}

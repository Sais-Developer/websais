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

    $stmt = $pdo->prepare("SELECT * FROM banksoal");
    $stmt->execute();
    $array_bank = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM soal");
    $stmt->execute();
    $array_soal = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM pengaturan");
    $stmt->execute();
    $array_jenis = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM ujian");
    $stmt->execute();
    $array_jadwal = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "bank"  => $array_bank,
        "soal"    => $array_soal,
        "jenis"=> $array_jenis,
        "jadwal"  => $array_jadwal
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "error"  => $e->getMessage()
    ]);
}
?>

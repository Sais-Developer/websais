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

    $stmt = $pdo->prepare("SELECT * FROM siswa");
    $stmt->execute();
    $array_siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM mapel");
    $stmt->execute();
    $array_mapel = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM guru");
    $stmt->execute();
    $array_guru = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM m_kelas");
    $stmt->execute();
    $array_kelas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "siswa"  => $array_siswa,
        "mapel"    => $array_mapel,
        "guru"=> $array_guru,
        "kelas"  => $array_kelas
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "error"  => $e->getMessage()
    ]);
}
?>

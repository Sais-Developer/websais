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

    $stmt = $pdo->prepare("SELECT * FROM datareg");
    $stmt->execute();
    $array_reg = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM waktu");
    $stmt->execute();
    $array_waktu = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM absensi");
    $stmt->execute();
    $array_absensi = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT * FROM absensi_les");
    $stmt->execute();
    $array_eskul = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$stmt = $pdo->prepare("SELECT * FROM absen_jjm");
    $stmt->execute();
    $array_jjm = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => true,
        "reg"  => $array_reg,
        "waktu"    => $array_waktu,
        "absensi"=> $array_absensi,
        "eskul"  => $array_eskul,
		"jjm"  => $array_jjm
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "error"  => $e->getMessage()
    ]);
}
?>

<?php
require("../konek/koneksi.php");
require("../konek/function.php");
$token = isset($_GET['token']) ? $_GET['token'] : 'false';

try {
    $stmt = $pdo->prepare("SELECT token_api FROM pengaturan WHERE token_api = :token LIMIT 1");
    $stmt->execute(['token' => $token]);
    $result = $stmt->fetch();

    if ($result) {
        echo json_encode([
            "status" => true,
            "message" => "Token valid, siap sinkronisasi"
        ]);

    } else {
        echo json_encode([
            "status" => false,
            "message" => "Token tidak valid"
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "status" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}

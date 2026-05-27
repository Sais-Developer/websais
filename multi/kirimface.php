<?php
require(__DIR__ . "/../konek/koneksi.php");

header('Content-Type: application/json; charset=utf-8');

/* =============================
   RESET TMPFACE
   ============================= */
$pdo->exec("TRUNCATE TABLE tmpface");

/* =============================
   AMBIL STATUS
   ============================= */
$status = $pdo->query("SELECT * FROM status LIMIT 1")->fetch(PDO::FETCH_ASSOC);

/* =============================
   PARAMETER
   ============================= */
$nokartu = $_GET['nokartu'] ?? '';

if ($nokartu === '') {
    echo json_encode([
        "status"  => "error",
        "message" => "Parameter nokartu kosong"
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

/* =============================
   CEK DATA REG
   ============================= */
$stmt = $pdo->prepare("
    SELECT * 
    FROM datareg 
    WHERE nokartu = :nokartu 
      AND folder <> ''
");
$stmt->execute(['nokartu' => $nokartu]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

/* =============================
   RESPONSE & INSERT TMPFACE
   ============================= */
$stmtInsert = $pdo->prepare("INSERT INTO tmpface (nokartu) VALUES (:nokartu)");
$stmtInsert->execute(['nokartu' => $nokartu]);

if (!$data) {
    $response = [
        "status"  => "error",
        "message" => "TIDAK TERDAFTAR"
    ];
} else {
    $response = [
        "status"  => "success",
        "message" => "TERDAFTAR",
        "nama"    => $data['nama'],
        "nada"    => (int) $data['nada']
    ];
}

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

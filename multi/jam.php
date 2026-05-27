<?php
header('Content-Type: application/json; charset=utf-8');
require(__DIR__ . "/../konek/koneksi.php");

$hari        = date('D');
$waktusandik = date('H:i');
$waktu       = date('H:i:s');

$response = [];

/* =======================
   PENGATURAN
======================= */
$stmt = $pdo->prepare("SELECT * FROM pengaturan WHERE id_aplikasi = 1 LIMIT 1");
$stmt->execute();
$setting = $stmt->fetch() ?: [];

/* =======================
   MODE ABSEN
======================= */
$stmt = $pdo->query("SELECT mode FROM status LIMIT 1");
$mode_absen = (int)($stmt->fetch()['mode'] ?? 0);

/* =======================
   RESET BELL
======================= */
$pdo->exec("
    UPDATE bell 
    SET sudah_main = 0 
    WHERE sudah_main = 1 
    AND waktu_main IS NOT NULL 
    AND TIMESTAMPDIFF(MINUTE, waktu_main, NOW()) >= 10
");

/* =======================
   CEK BELL
======================= */
$stmt = $pdo->prepare("
    SELECT * FROM bell 
    WHERE jam = ? AND hari = ? AND sudah_main = 0 
    LIMIT 1
");
$stmt->execute([$waktusandik, $hari]);
$row = $stmt->fetch() ?: [];

if ($row) {
    $stmt = $pdo->prepare("
        UPDATE bell 
        SET sudah_main = 1, waktu_main = ? 
        WHERE id = ?
    ");
    $stmt->execute([date('Y-m-d H:i:s'), $row['id']]);
}

$nada = $row['nada'] ?? '';

/* =======================
   STATUS ABSEN
======================= */
switch ($mode_absen) {
    case 2: $status = "Pulang"; break;
    case 3: $status = "In Les"; break;
    case 4: $status = "Out Les"; break;
    case 5: $status = "Piket  "; break;
    default: $status ="Masuk  "; break;
}

$response = [
    "jam"    => $waktusandik,
    "status" => $status
];

if (in_array($setting['mesin'] ?? 0, [2, 5])) {
    $response["lagu"] = $nada;
}

/* =======================
   UPDATE MODE BERDASARKAN WAKTU
======================= */
$stmt = $pdo->prepare("SELECT * FROM waktu WHERE hari = ?");
$stmt->execute([$hari]);

while ($data = $stmt->fetch()) {
    $masuk        = $data['masuk'];
    $pulang       = $data['pulang'];
    $masuk_eskul  = $data['masuk_eskul'];
    $pulang_eskul = $data['pulang_eskul'];
    $piket        = $data['piket'];

    if ($masuk && strtotime($waktusandik) <= strtotime($pulang)) {
        $pdo->exec("UPDATE status SET mode='1'");
        break;
    }
    if ($pulang && strtotime($waktusandik) >= strtotime($pulang)) {
        $pdo->exec("UPDATE status SET mode='2'");
        break;
    }
    if ($masuk_eskul && strtotime($waktusandik) >= strtotime($masuk_eskul) && strtotime($waktusandik) < strtotime($pulang_eskul)) {
        $pdo->exec("UPDATE status SET mode='3'");
        break;
    }
    if ($pulang_eskul && strtotime($waktusandik) >= strtotime($pulang_eskul)) {
        $pdo->exec("UPDATE status SET mode='4'");
        break;
    }
    if ($piket && strtotime($waktusandik) >= strtotime($piket)) {
        $pdo->exec("UPDATE status SET mode='5'");
        break;
    }
}

echo json_encode($response);

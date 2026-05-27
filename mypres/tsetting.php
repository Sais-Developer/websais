<?php
require("../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';

$pesan1 = $_POST['pesan1'] ?? '';
$pesan2 = $_POST['pesan2'] ?? '';
$pesan3 = $_POST['pesan3'] ?? '';
$pesan4 = $_POST['pesan4'] ?? '';

$mapPgToId = [
    'masuksis'    => 1,
    'pulangsis'   => 2,
    'masukpeg'    => 3,
    'pulangpeg'   => 4,
    'masukeksis'  => 5,
    'pulangeksis' => 6,
    'masukekpeg'  => 7,
    'pulangekpeg' => 8
];

if (array_key_exists($pg, $mapPgToId)) {
    $id = $mapPgToId[$pg];

    $stmt = $db->prepare("
        UPDATE m_pesan SET 
            pesan1 = :pesan1, 
            pesan2 = :pesan2, 
            pesan3 = :pesan3, 
            pesan4 = :pesan4
        WHERE id = :id
    ");

    $stmt->execute([
        'pesan1' => $pesan1,
        'pesan2' => $pesan2,
        'pesan3' => $pesan3,
        'pesan4' => $pesan4,
        'id'     => $id
    ]);
}
?>

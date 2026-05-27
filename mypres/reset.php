<?php
require("../konek/koneksi.php"); // $db = PDO

    $neuralFile = '../neural.json';
    if (file_exists($neuralFile)) {
        unlink($neuralFile);
    }

    $from = '../json/neural.json';
    $to = '../neural.json';
    if (file_exists($from)) {
        copy($from, $to);
    }

    $stmt = $db->query("SELECT * FROM datareg");
    $dataregs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($dataregs as $data) {
        $folderPath = '../data/' . ($data['folder'] ?? '');
        if (is_dir($folderPath)) {
            $files = glob($folderPath . '/*');
            foreach ($files as $filex) {
                if (is_file($filex)) {
                    unlink($filex);
                }
            }
            rmdir($folderPath);
        }
    }

    $db->exec("UPDATE siswa SET sts='0'");
    $db->exec("UPDATE guru SET sts='0'");

    $tables = [
        'absensi','absensi_les','datareg','jadwal_mengajar','m_eskul',
        'tmpface','pesan_terkirim'
    ];

    foreach ($tables as $tbl) {
        $db->exec("TRUNCATE TABLE `$tbl`");
    }
$stmt = $pdo->prepare("
    UPDATE sinkron 
    SET jumlah = 0, tanggal = NULL 
    WHERE id BETWEEN 9 AND 13
");
$stmt->execute();
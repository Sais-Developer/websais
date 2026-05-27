<?php
require("../konek/koneksi.php"); 

$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

$tables = [
    'kokurikuler',
    'mapel_rapor',
    'nilai_rapor',
	'catatan_rapor',
	'absen_rapor',
    'tanggal_rapor',
    'nilai_capaian',
    'peskul'
];

foreach ($tables as $tbl) {

    try {
        $pdo->exec("TRUNCATE `$tbl`");
        echo "Tabel `$tbl` berhasil dikosongkan.<br>";
    } catch (PDOException $e) {
        echo "Gagal truncate `$tbl`: " . $e->getMessage() . "<br>";
    }

}

$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

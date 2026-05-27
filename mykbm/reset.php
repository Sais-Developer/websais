<?php
require("../konek/koneksi.php"); 

try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    $tables = [
        'jadwal_mengajar',
        'cp_elemen',
        'adm_tp',
        'agenda',
		'jurnal',
        'nilai_harian'
    ];

    foreach ($tables as $tbl) {
        $sql = "TRUNCATE TABLE `$tbl`";
        $pdo->exec($sql);
        echo "Tabel `$tbl` berhasil dikosongkan.<br>";
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

} catch (PDOException $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>

<?php
require("../../konek/koneksi.php"); 

try {
   
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    $tables = [
        'm_bayar',
        'trx_bayar',
        'absen_jjm',
        'pay_lainnya'
    ];

    foreach ($tables as $tbl) {
        $query = "TRUNCATE TABLE `$tbl`";
        $pdo->exec($query); 
        echo "Tabel `$tbl` berhasil dikosongkan.<br>";
    }

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

} catch (PDOException $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>

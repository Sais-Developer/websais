<?php
require("../../konek/koneksi.php"); 

try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    $tables = [
        'saldo'  
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
    $stmt = $pdo->prepare("UPDATE siswa SET saldo = 0");
    $stmt->execute();
    echo "Saldo siswa berhasil direset ke 0.<br>";

} catch (PDOException $e) {
    echo "Terjadi kesalahan: " . $e->getMessage() . "<br>";
}
?>

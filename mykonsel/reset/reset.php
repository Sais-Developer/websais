<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

$tables = [
    'catatan_pelanggaran',
    'konseling'
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

$stmt = $pdo->prepare("
    UPDATE siswa 
    SET total_poin = 0, 
        id_teguran = NULL
");

if ($stmt->execute()) {
    echo "Data siswa berhasil di-reset.";
} else {
    $error = $stmt->errorInfo();
    echo "Gagal reset data siswa: " . $error[2];
}

$stmt = null;
?>

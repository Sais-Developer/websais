<?php
require("../../konek/koneksi.php"); 

try {
   
    $pdo->exec("TRUNCATE TABLE nilai_skl");
    $pdo->exec("UPDATE siswa SET ket = NULL");

    echo "Tabel 'nilai_skl' berhasil dikosongkan dan kolom 'ket' pada siswa direset.";
} catch (PDOException $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>

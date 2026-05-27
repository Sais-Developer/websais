<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require("../../konek/crud.php");

try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    $tables = [
        'pkl_presensi',
        'pkl_jurnal',
        'pkl_nilai',
        'pkl_dudi',
        'pkl_siswa'
    ];

    foreach ($tables as $tbl) {
        $stmt = $pdo->prepare("TRUNCATE `$tbl`");
        if ($stmt->execute()) {
            echo "Tabel `$tbl` berhasil dikosongkan.<br>";
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Gagal truncate `$tbl`: " . $errorInfo[2] . "<br>";
        }
    }

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

function bersihkan_folder($dir)
{
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $item) {
        if ($item === '.' || $item === '..') continue;

        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            bersihkan_folder($path);
            rmdir($path);
        } else {
            unlink($path);
        }
    }
}

$dirs = ['../../images/prakerin', '../../images/fotopkl', '../../images/ttd'];
foreach ($dirs as $dir) {
    $real = realpath($dir);
    if ($real) {
        bersihkan_folder($real);
        echo "Semua isi folder '$real' berhasil dihapus.<br>";
    } else {
        echo "Folder tidak ditemukan: $dir<br>";
    }
}

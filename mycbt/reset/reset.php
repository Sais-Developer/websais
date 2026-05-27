<?php
require("../../konek/koneksi.php"); 
require("../../konek/function.php");

try {
    if (!$pdo) {
        throw new Exception("Koneksi PDO belum dibuat.");
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    $tables = [
        'jawaban',
        'banksoal',
        'soal',
        'berita',
        'ujian',
        'arsip_jawaban',
        'pengumuman',
        'nilai'
    ];

    foreach ($tables as $tbl) {
        try {
            $pdo->exec("TRUNCATE TABLE `$tbl`");
            echo "Tabel `$tbl` berhasil dikosongkan.<br>";
        } catch (PDOException $e) {
            echo "Gagal truncate `$tbl`: " . $e->getMessage() . "<br>";
        }
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

} catch (PDOException $e) {
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

function bersihkan_folder($dir)
{
    if (!is_dir($dir)) return;

    $files = scandir($dir);
    foreach ($files as $item) {
        if ($item == '.' || $item == '..') continue;

        $path = "$dir/$item";
        if (is_file($path) && strtolower($item) === '.htaccess') {
            continue;
        }

        if (is_dir($path)) {
            bersihkan_folder($path);
            @rmdir($path);
        } else {
            @unlink($path);
        }
    }
}

$dirs = ['../../files', '../../temp'];
foreach ($dirs as $dir) {
    $real = realpath($dir);
    if ($real) {
        bersihkan_folder($real);
        echo "Semua isi folder '$real' berhasil dihapus kecuali .htaccess.<br>";
    } else {
        echo "Folder tidak ditemukan: $dir<br>";
    }
}
$stmt = $pdo->prepare("
    UPDATE sinkron 
    SET jumlah = 0, tanggal = NULL 
    WHERE id BETWEEN 5 AND 8
");
$stmt->execute();
?>

<?php
require("../../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';
$rest_dir = "../../backup/"; 

if ($pg == 'setting_restore') {

    function restore($file, $pdo, $rest_dir)
    {
        $nama_file = $file['name'] ?? '';
        $tmp_file  = $file['tmp_name'] ?? '';
        $error     = $file['error'] ?? '';

        if ($nama_file == '') {
            echo "Fatal Error: file tidak ditemukan";
            return;
        }

        $alamatfile = $rest_dir . $nama_file;
        if (move_uploaded_file($tmp_file, $alamatfile)) {
            $lines = file($alamatfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $templine = "";

            foreach ($lines as $line) {
                if (substr($line, 0, 2) == '--') continue;

                $templine .= $line . "\n";
                if (substr(trim($line), -1) == ';') {
                    try {
                        $pdo->exec($templine);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage() . "<br>";
                    }
                    $templine = "";
                }
            }
        } else {
            echo "Proses upload gagal, kode error = " . $error;
            return;
        }
    }

    if (isset($_FILES['datafile'])) {
        restore($_FILES['datafile'], $pdo, $rest_dir);
        echo "Data berhasil direstore";
    }
}

if ($pg == 'reset') {

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    $tables = [
	    'alumni',
	    'bell',
        'siswa',
        'mapel',
        'm_eskul',
		'm_kelas',
        'guru',
        'kebiasaan_harian'
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
}
$stmt = $pdo->prepare("
    UPDATE sinkron 
    SET jumlah = 0, tanggal = NULL 
    WHERE id BETWEEN 1 AND 4
");
$stmt->execute();

?>

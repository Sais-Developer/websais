<?php
require("../konek/koneksi.php"); 

    $tables = [
        'materi','absen_daring','tugas','jawaban_tugas'
    ];

    foreach ($tables as $tbl) {
        $db->exec("TRUNCATE TABLE `$tbl`");
    }

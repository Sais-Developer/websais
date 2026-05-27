<?php
require "../../konek/koneksi.php"; // $db = PDO
require "../../vendor/autoload.php";
require "../../konek/crud.php";

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (!empty($_FILES['file']['tmp_name'])) {

    $allowed_ext = ['xls','xlsx'];
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        echo "0"; 
        exit;
    }

    try {
        $reader = ($ext === 'xls') ? new Xls() : new Xlsx();
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $db->exec("TRUNCATE mapel");

        for ($i = 4; $i < count($sheetData); $i++) {
            $kode = trim($sheetData[$i][1] ?? '');
            $nama = trim($sheetData[$i][2] ?? '');

            if ($kode !== '' && $nama !== '') {
                insert("mapel", [
                    "kode" => $kode,
                    "nama_mapel" => $nama
                ]);
            }
        }

        echo "1"; 
    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        error_log("Import Error: " . $e->getMessage());
        echo "0"; 
    }
} else {
    echo "0"; 
}
